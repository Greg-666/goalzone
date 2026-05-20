<?php
// ============================================
// Appel API LLM pour générer les aperçus tactiques
// ============================================

require_once __DIR__ . '/../config/api.php';

/**
 * Génère un aperçu tactique pour un match via l'API Claude
 * Retourne le texte généré ou null en cas d'erreur
 */
function generer_apercu_match(array $match): ?string
{
    // Construction du prompt
    $prompt = construire_prompt($match);

    // Appel API via cURL
    $reponse = appeler_api_claude($prompt);

    if ($reponse === null) {
        return null;
    }

    return $reponse;
}

/**
 * Construit le prompt envoyé à l'API
 */
function construire_prompt(array $match): string
{
    $equipe_dom = htmlspecialchars($match['equipe_dom']);
    $equipe_ext = htmlspecialchars($match['equipe_ext']);
    $stade      = htmlspecialchars($match['stade']);
    $ville      = htmlspecialchars($match['ville']);
    $date       = date('d/m/Y à H:i', strtotime($match['date_match']));
    $phase      = ucfirst($match['phase']);

    return "Tu es un analyste football expert. Génère un aperçu tactique en français 
pour le match suivant de la Coupe du Monde 2026 :

Match : {$equipe_dom} vs {$equipe_ext}
Phase : {$phase}
Stade : {$stade}, {$ville}
Date : {$date}

Rédige un aperçu de 150 à 200 mots maximum, structuré ainsi :
1. Contexte du match et enjeux
2. Forces et faiblesses des deux équipes
3. Joueurs clés à surveiller
4. Pronostic

Utilise un ton journalistique, dynamique et accessible. 
Ne mets pas de titres ni de puces, rédige en paragraphes fluides.
Réponds uniquement avec l'aperçu, sans introduction ni conclusion.";
}

/**
 * Appelle l'API Claude via cURL
 * Retourne le texte de la réponse ou null en cas d'erreur
 */
function appeler_api_claude(string $prompt): ?string
{
    $donnees = json_encode([
        'model'      => LLM_MODEL,
        'max_tokens' => 1024,
        'messages'   => [
            [
                'role'    => 'user',
                'content' => $prompt
            ]
        ]
    ]);

    $ch = curl_init(LLM_API_URL);

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => $donnees,
        CURLOPT_HTTPHEADER     => [
            'Content-Type: application/json',
            'x-api-key: ' . LLM_API_KEY,
            'anthropic-version: 2023-06-01'
        ],
        CURLOPT_TIMEOUT        => 30,
    ]);

    $reponse_brute = curl_exec($ch);
    $erreur        = curl_error($ch);
    $code_http     = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Gestion des erreurs cURL
    if ($erreur) {
        error_log('GoalZone IA - Erreur cURL : ' . $erreur);
        return null;
    }

    // Gestion des erreurs HTTP
    if ($code_http !== 200) {
        error_log('GoalZone IA - Erreur HTTP ' . $code_http . ' : ' . $reponse_brute);
        return null;
    }

    // Décodage JSON
    $reponse = json_decode($reponse_brute, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        error_log('GoalZone IA - Erreur JSON : ' . json_last_error_msg());
        return null;
    }

    // Extraction du texte
    if (!isset($reponse['content'][0]['text'])) {
        error_log('GoalZone IA - Structure de réponse inattendue');
        return null;
    }

    return trim($reponse['content'][0]['text']);
}

/**
 * Sauvegarde l'aperçu généré en base de données
 */
function sauvegarder_apercu(PDO $pdo, int $match_id, string $apercu): bool
{
    $stmt = $pdo->prepare(
        'UPDATE matchs SET apercu_ia = ?, apercu_genere = 1 WHERE id = ?'
    );
    return $stmt->execute([$apercu, $match_id]);
}
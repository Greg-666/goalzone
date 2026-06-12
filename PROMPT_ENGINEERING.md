# Note de Prompt Engineering — GoalZone IA

## Contexte

GoalZone utilise l'API Claude (Anthropic) pour générer automatiquement des aperçus
tactiques pour chaque match de la Coupe du Monde 2026. Cette note explique les
choix de conception du prompt utilisé.

---

## Le prompt utilisé

---

## Analyse des choix

### 1. Définition du rôle

Donner un rôle précis au modèle oriente son registre et sa terminologie.
Un analyste football utilise naturellement le vocabulaire tactique approprié
(pressing, bloc défensif, transitions, etc.) sans qu'on ait besoin de le préciser.

### 2. Contexte structuré

Les données sont injectées dynamiquement depuis la base de données.
Les présenter sous forme de liste clé/valeur est plus lisible et fiable
qu'une phrase narrative, ce qui réduit les risques d'hallucination.

### 3. Contrainte de longueur

Sans contrainte, le modèle peut produire des textes trop longs pour
l'affichage prévu. La fourchette 150-200 mots garantit un contenu
dense et lisible sur la page détail du match.

### 4. Structure imposée

Imposer un plan garantit la cohérence entre tous les aperçus générés.
Chaque aperçu suit la même logique narrative, ce qui améliore
l'expérience utilisateur.

### 5. Contrainte de format

Sans cette instruction, le modèle tend à utiliser des titres Markdown
(`##`) ou des listes à puces qui rendraient mal dans le HTML.
Cette contrainte force une prose continue, plus agréable à lire.

### 6. Délimitation de la réponse

Sans cette instruction, le modèle ajoute souvent des phrases comme
"Bien sûr, voici l'aperçu..." ou "J'espère que cela vous aide !"
qui sont inutiles et polluent l'affichage.

---

## Résultats obtenus

| Critère          | Résultat                                 |
| ---------------- | ---------------------------------------- |
| Longueur moyenne | ~175 mots                                |
| Ton              | Journalistique et dynamique              |
| Format           | Prose fluide, pas de markdown            |
| Pertinence       | Contexte et enjeux bien intégrés         |
| Cohérence        | Structure identique pour tous les matchs |

---

## Améliorations possibles

1. **Enrichir le contexte** : ajouter les statistiques des joueurs
   (buts marqués, passes décisives) pour des analyses plus précises
2. **Prompt multilingue** : adapter le prompt pour générer
   des aperçus en néerlandais ou en anglais
3. **Température** : tester différentes valeurs de température
   pour varier le style rédactionnel
4. **Few-shot** : fournir un exemple d'aperçu idéal dans le prompt
   pour guider encore mieux le modèle

---

## Référence technique

- **Modèle** : claude-sonnet-4-6
- **max_tokens** : 1024
- **Endpoint** : `https://api.anthropic.com/v1/messages`
- **Implémentation** : `includes/ia.php`

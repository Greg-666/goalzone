# GoalZone — Coupe du Monde 2026

Site compagnon francophone pour la Coupe du Monde 2026, développé dans le cadre de la formation PHP à l'IFAPME Charleroi.

---

## 📋 Description

GoalZone est une application web full-stack permettant de suivre la Coupe du Monde 2026 (États-Unis, Canada, Mexique). Elle propose :

- Un **frontoffice** public : calendrier des matchs, fiches équipes, joueurs, formulaire de contact, inscription/connexion
- Un **backoffice** admin : gestion complète (CRUD) des matchs, équipes, joueurs, stades et messages
- Une **fonctionnalité IA** : génération d'aperçus tactiques via l'API Claude (Anthropic)

---

## 🛠️ Stack technique

| Technologie | Version           | Rôle                           |
| ----------- | ----------------- | ------------------------------ |
| PHP         | 8.1+              | Backend                        |
| MySQL       | 8.0               | Base de données                |
| SCSS        | —                 | Styles (compilé via Live Sass) |
| PDO         | —                 | Accès base de données          |
| Claude API  | claude-sonnet-4-6 | Génération aperçus IA          |

---

## 📁 Structure du projet

---

## 🚀 Installation

### 1. Cloner le projet

```bash
git clone https://github.com/votre-pseudo/goalzone.git
cd goalzone
```

### 2. Configurer la base de données

- Importer `sql/seed.sql` dans phpMyAdmin
- La base contient 9 tables, 48 équipes, 288 joueurs, 16 stades, 32 matchs

### 3. Configurer la connexion DB

Ouvrir `includes/db.php` et renseigner :

```php
define('DB_HOST', 'adresse-du-serveur');
define('DB_NAME', 'nom-de-la-base');
define('DB_USER', 'utilisateur');
define('DB_PASS', 'mot-de-passe');
```

### 4. Configurer l'API Claude

Copier `config/api.php.example` vers `config/api.php` et renseigner :

```php
define('LLM_API_KEY', 'votre-cle-api-anthropic');
define('LLM_API_URL', 'https://api.anthropic.com/v1/messages');
define('LLM_MODEL',   'claude-sonnet-4-6');
```

> ⚠️ Ne jamais commiter `config/api.php` — il est dans `.gitignore`

### 5. Compiler le SCSS

Dans VS Code, activer **Live Sass Compiler** → "Watch Sass"

---

## 👤 Comptes de test

| Email               | Mot de passe | Rôle   |
| ------------------- | ------------ | ------ |
| admin@goalzone.be   | Password123! | Admin  |
| membre1@goalzone.be | Password123! | Membre |
| membre2@goalzone.be | Password123! | Membre |

---

## 🔒 Sécurité

- Requêtes SQL via **PDO préparé** (protection injection SQL)
- Affichage via **`htmlspecialchars()`** (protection XSS)
- Mots de passe hashés avec **`password_hash()`** (bcrypt)
- Sessions PHP sécurisées
- Clé API hors dépôt Git

---

## ⚡ Fonctionnalité IA

Les aperçus tactiques sont générés via l'API **Claude** d'Anthropic.

- Accessible depuis le backoffice → Matchs → Éditer → "Générer l'aperçu IA"
- Le prompt demande un analyse de 150-200 mots : contexte, forces/faiblesses, joueurs clés, pronostic
- L'aperçu est sauvegardé en base et affiché sur la page détail du match

---

## 📚 Contexte

Projet réalisé dans le cadre de la formation **Développeur Web** à l'**IFAPME Charleroi**.

- Cours : PHP / MySQL / SCSS
- Année : 2025-2026

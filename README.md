<p align="center">
  <img src="./assests/logo.png" alt="InternHub Logo" width="360"/>
</p>

<h3 align="center">Simplifying Internships, Connecting Opportunities</h3>

<p align="center">
  InternHub est une plateforme web centralisée dédiée à la gestion et au suivi des stages,
  mettant en relation les étudiants, les entreprises, les encadrants et l'administration.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/status-in%20development-16425B?style=for-the-badge" alt="status"/>
  <img src="https://img.shields.io/badge/Vue.js-3-3A7CA5?style=for-the-badge&logo=vue.js&logoColor=white" alt="vue"/>
  <img src="https://img.shields.io/badge/Laravel-13-16425B?style=for-the-badge&logo=laravel&logoColor=white" alt="laravel"/>
  <img src="https://img.shields.io/badge/FastAPI-Python-3A7CA5?style=for-the-badge&logo=fastapi&logoColor=white" alt="fastapi"/>
  <img src="https://img.shields.io/badge/PostgreSQL-16-16425B?style=for-the-badge&logo=postgresql&logoColor=white" alt="postgresql"/>
  <img src="https://img.shields.io/badge/Docker-Compose-3A7CA5?style=for-the-badge&logo=docker&logoColor=white" alt="docker"/>
</p>

<p align="center">
  <img src="./assets/divider.svg" width="100%" height="4" alt=""/>
</p>

# 🎓 Présentation du projet

**InternHub** est une plateforme web de gestion des stages développée dans le cadre d'un **projet de soutenance de cycle ingénieur**.

L'objectif principal est de centraliser l'ensemble du processus de gestion des stages au sein d'une seule application : publication des offres, candidature des étudiants, gestion des entreprises, suivi des stages, encadrement, évaluation et gestion administrative.

La plateforme permet ainsi de faciliter la communication entre les différents acteurs et d'améliorer la traçabilité des différentes étapes du parcours de stage.

InternHub est conçu comme une application **moderne, responsive, sécurisée et évolutive**, avec une architecture permettant de séparer les différentes couches de l'application.

<p align="center">
  <img src="./assets/divider.svg" width="100%" height="4" alt=""/>
</p>

# 🎯 Contexte et problématique

La gestion des stages implique plusieurs acteurs et de nombreuses opérations :

* Recherche et publication des offres de stage
* Dépôt et traitement des candidatures
* Communication entre étudiants et entreprises
* Affectation des encadrants
* Suivi de l'avancement des stages
* Évaluation des étudiants
* Gestion des documents
* Suivi administratif

Lorsque ces opérations sont réalisées à travers plusieurs outils ou de manière manuelle, cela peut entraîner :

* Une perte d'informations
* Un manque de visibilité sur l'avancement des stages
* Des difficultés de communication
* Une duplication des données
* Un suivi administratif complexe

### Problématique

> **Comment concevoir une plateforme web centralisée permettant de digitaliser, simplifier et améliorer la gestion et le suivi des stages pour les étudiants, les entreprises, les encadrants et l'administration ?**

InternHub apporte une réponse à cette problématique à travers une plateforme unique regroupant les différents processus liés aux stages.

<p align="center">
  <img src="./assets/divider.svg" width="100%" height="4" alt=""/>
</p>

# 💡 Objectifs

## 🎯 Objectif général

Développer une plateforme web centralisée permettant de gérer l'ensemble du cycle de vie d'un stage.

## 📌 Objectifs spécifiques

* Centraliser les offres de stage
* Faciliter la recherche d'opportunités pour les étudiants
* Digitaliser le processus de candidature
* Faciliter la gestion des entreprises
* Permettre le suivi des candidatures
* Faciliter l'encadrement des étudiants
* Assurer le suivi de l'avancement des stages
* Centraliser les évaluations et rapports
* Automatiser certaines tâches administratives
* Mettre en place un système de notifications
* Fournir des tableaux de bord adaptés à chaque acteur
* Préparer l'intégration de fonctionnalités basées sur l'intelligence artificielle

<p align="center">
  <img src="./assets/divider.svg" width="100%" height="4" alt=""/>
</p>

# 👥 Acteurs du système

InternHub repose sur plusieurs profils utilisateurs.

| Acteur                         | Responsabilités principales                                                  |
| ------------------------------ | ---------------------------------------------------------------------------- |
| 👨‍🎓 **Étudiant / Stagiaire** | Consulter les offres, candidater, suivre ses candidatures et son stage       |
| 🏢 **Entreprise**              | Gérer son profil, publier des offres et traiter les candidatures             |
| 👨‍🏫 **Encadrant entreprise** | Suivre le stagiaire, superviser son évolution et participer à son évaluation |
| 👨‍💼 **Administrateur**       | Administrer les utilisateurs, les stages, les entreprises et la plateforme   |

<p align="center">
  <img src="./assets/divider.svg" width="100%" height="4" alt=""/>
</p>

# 🛠️ Technologies utilisées

| Couche                 | Technologies                 |
| ---------------------- | ---------------------------- |
| **Frontend**           | Vue.js 3, Tailwind CSS, Vite |
| **Gestion d'état**     | Pinia                        |
| **Routing Frontend**   | Vue Router                   |
| **Backend**            | Laravel 13, PHP 8.4          |
| **Service IA**         | Python, FastAPI              |
| **Base de données**    | PostgreSQL 16                |
| **Serveur Web**        | Nginx                        |
| **Administration BDD** | pgAdmin 4                    |
| **Conteneurisation**   | Docker, Docker Compose       |
| **Versioning**         | Git, GitHub                  |
| **CI/CD**              | GitHub Actions               |

<p align="center">
  <img src="./assets/divider.svg" width="100%" height="4" alt=""/>
</p>

# 📁 Structure du projet

```text
internhub-platform/
│
├── docker-compose.yml      orchestration des six services
├── README.md               présentation, équipe, stratégie Git
├── .gitignore
│
├── nginx/
│   └── nginx.conf          serveur frontal et règles de routage
│
├── backend/                       code serveur + front intégré
│   └── laravel/                   application Laravel 13
│       ├── Dockerfile
│       ├── composer.json          dépendances PHP
│       ├── package.json           dépendances front (Vue 3, Vite)
│       ├── vite.config.js         configuration de build Vite
│       ├── artisan                utilitaire en ligne de commande
│       ├── app/
│       │   ├── Models/            modèles Eloquent
│       │   ├── Http/Controllers/
│       │   └── Providers/
│       ├── routes/                web.php, api.php, console.php
│       ├── config/                app, auth, database, session…
│       ├── database/
│       │   ├── migrations/        schéma versionné
│       │   ├── seeders/           données de démonstration
│       │   └── factories/         générateurs de données de test
│       ├── resources/             ressources front-end
│       │   ├── css/               styles CSS
│       │   ├── js/                code JavaScript et Vue.js
│       │   │   ├── Components/    composants Vue réutilisables
│       │   │   ├── Layouts/       structures des pages
│       │   │   ├── Pages/         pages de l'application
│       │   │   ├── router/        configuration Vue Router
│       │   │   ├── services/      appels aux API
│       │   │   ├── app.js         point d'entrée Vue.js
│       │   │   └── bootstrap.js   configuration JavaScript
│       │   └── views/             vues Blade (app.blade.php)
│       ├── storage/               journaux, cache, fichiers déposés
│       ├── tests/                 Feature/ et Unit/
│       └── public/                racine web (index.php, build Vite)
│
└── fastapi/                micro-service IA
    ├── Dockerfile
    ├── requirements.txt
    └── app/
        └── main.py         points d'entrée FastAPI

```

<p align="center">
  <img src="./assets/divider.svg" width="100%" height="4" alt=""/>
</p>

# 🌿 Organisation Git

Le projet utilise une organisation Git inspirée de **Git Flow**.

## Branches principales

| Branche   | Utilisation                         |
| --------- | ----------------------------------- |
| `main`    | Version stable du projet            |
| `develop` | Branche principale de développement |

## Branches fonctionnelles

```text
feature/authentication
feature/student-module
feature/company-module
feature/supervisor-module
feature/admin-module
feature/notifications
feature/reports
feature/ai-features
feature/frontend-ui
feature/devops
```

## Workflow

```text
                    ┌──────────────┐
                    │   feature/*  │
                    └──────┬───────┘
                           │
                           ▼
                    ┌──────────────┐
                    │    develop   │
                    └──────┬───────┘
                           │
                           ▼
                    ┌──────────────┐
                    │   release/*  │
                    └──────┬───────┘
                           │
                           ▼
                    ┌──────────────┐
                    │     main     │
                    └──────────────┘
```

Pour les corrections urgentes :

```text
hotfix/*
```

Pour les modifications liées à la documentation :

```text
docs/*
```

<p align="center">
  <img src="./assets/divider.svg" width="100%" height="4" alt=""/>
</p>

# 🚀 Installation et lancement

Grâce à Docker, l'environnement de développement peut être exécuté sans installer directement PHP, Node.js ou PostgreSQL sur la machine.

## Prérequis

* Docker Desktop ou Docker Engine
* Docker Compose v2
* Git

## 1. Cloner le projet

```bash
git clone https://github.com/soukayna00/internhub-platform.git
cd internhub-platform
```

## 2. Vérifier Docker

```bash
docker --version
docker compose version
```

## 3. Construire et démarrer les services

```bash
docker compose up -d --build
```

## 4. Vérifier les conteneurs

```bash
docker compose ps
```

## 5. Consulter les logs

```bash
docker compose logs
```

Pour un service spécifique :

```bash
docker compose logs backend
docker compose logs fastapi
```

## 6. Générer la clé Laravel

```bash
docker compose exec backend php artisan key:generate
```

## 7. Exécuter les migrations

```bash
docker compose exec backend php artisan migrate
```

## 8. Vérifier les routes Laravel

```bash
docker compose exec backend php artisan route:list
```

## 9. Arrêter les services

```bash
docker compose down
```

## 10. Redémarrer le projet

```bash
docker compose up -d
```

## 🌐 Accès aux services

| Service             | URL                     |
| ------------------- | ----------------------- | |
| **Backend Laravel** | `http://localhost:8000` |
| **FastAPI**         | `http://localhost:8001` |
| **Nginx**           | `http://localhost`      |
| **pgAdmin**         | `http://localhost:5050` |

<p align="center">
  <img src="./assets/divider.svg" width="100%" height="4" alt=""/>
</p>

# 🐳 Services Docker

InternHub est composé de six services principaux.

| Service    | Image              | Port | Rôle                      |
| ---------- | ------------------ | ---: | ------------------------- |
| `nginx`    | `nginx:alpine`     |   80 | Reverse proxy             |
| `frontend` | `node:22-alpine`   | 5173 | Application Vue.js        |
| `backend`  | PHP / Laravel      | 8000 | API et logique métier     |
| `fastapi`  | `python:3.12-slim` | 8001 | Services IA               |
| `postgres` | `postgres:16`      | 5432 | Base de données           |
| `pgadmin`  | `dpage/pgadmin4`   | 5050 | Administration PostgreSQL |

<p align="center">
  <img src="./assets/divider.svg" width="100%" height="4" alt=""/>
</p>

# 👥 Équipe

Projet réalisé par une équipe de six étudiants ingénieurs.

| Membre                    | Rôle                                                                                          |
| ------------------------- | ----------------------------------------------------------------------------------------------|
| **Nour El Houda Sahli**   | Project Manager & Full Stack Developer & CI/CD                                                |
| **Wisal Nijad**           | Assistant Project Manager & Full Stack Developer & Docker Infrastructure/Cloud & AI Engineer  |
| **Soukayna Zaidi**        | Frontend Developer & Infrastructure Security Engineer                                         |
| **Mohamed Reda Hachoum**  | Backend Developer & AI Engineer                                                               |
| **Ziad Chelouati**        | Application Security Engineer & Full Stack Developer                                          |
| **Moulay Youssef Bahedi** | Quality Assurance Engineer & Backend Developer                                                |

<p align="center">
  <img src="./assets/divider.svg" width="100%" height="4" alt=""/>
</p>

# 🎨 Design System

InternHub utilise une identité visuelle basée principalement sur des nuances de bleu afin de transmettre une image professionnelle, moderne et fiable.

| Couleur       | Code HEX  | Utilisation                         |
| ------------- | --------- | ----------------------------------- |
| **Navy**      | `#16425B` | Couleur principale, titres, boutons |
| **Steel**     | `#3A7CA5` | Liens, icônes, éléments interactifs |
| **Cyan**      | `#81C3D7` | Accents, badges, états actifs       |
| **Soft Blue** | `#E8F1F5` | Arrière-plans et cartes             |

<p align="center">
  <img src="./assets/divider.svg" width="100%" height="4" alt=""/>
</p>

# 🤝 Contribution

Pour contribuer au projet :

### 1. Créer une branche

```bash
git checkout develop
git pull origin develop
git checkout -b feature/nom-de-la-fonctionnalite
```

### 2. Développer la fonctionnalité

Effectuer les modifications nécessaires tout en respectant l'architecture existante.

### 3. Tester les modifications

Vérifier que les nouvelles fonctionnalités n'introduisent pas de régression.

### 4. Créer un commit

```bash
git add .
git commit -m "feat: description de la fonctionnalité"
```

### 5. Envoyer la branche

```bash
git push origin feature/nom-de-la-fonctionnalite
```

### 6. Pull Request

Créer une Pull Request vers la branche `develop`.

<p align="center">
  <img src="./assets/divider.svg" width="100%" height="4" alt=""/>
</p>

# 📄 Licence

Ce projet est développé dans le cadre d'un **projet de soutenance de cycle ingénieur**.

Si une licence open source est appliquée au dépôt, elle peut être indiquée ici.

**MIT License**

Voir le fichier `LICENSE` pour plus d'informations.

<p align="center">
  <img src="./assets/divider.svg" width="100%" height="4" alt=""/>
</p>

# 📬 Contact

Pour toute question concernant le projet, une fonctionnalité ou un problème technique, veuillez ouvrir une **Issue GitHub** ou contacter les membres de l'équipe.

<p align="center">
  <img src="./assets/divider.svg" width="100%" height="4" alt=""/>
</p>

<p align="center">
  Developed by the <strong>InternHub Team</strong>
</p>

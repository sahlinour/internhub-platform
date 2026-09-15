# 🚀 InternHub

> **InternHub** is a smart internship management platform designed to streamline the internship process by connecting interns, companies, companies supervisors , and administrators within a centralized and intelligent web application.

---

## ✨ Features

### 👨‍🎓 Intern Portal
- Secure authentication
- Personal dashboard
- Browse internship offers
- Apply for internships
- Upload and manage CVs
- Track applications
- Receive notifications

### 🏢 Company Portal
- Company profile management
- Publish internship opportunities
- Review applications
- Manage candidates

### 👨‍🏫 Company supervisor Portal
- Supervise students
- Validate internships
- Monitor internship progress
- Evaluate students

### 👨‍💼 Administration
- User management
- Internship management
- Dashboard & analytics
- Reports generation
- Platform configuration

### 🤖 AI Features
- Smart internship recommendations
- CV analysis
- Intelligent search
- AI-powered assistance

---

## 🛠️ Tech Stack

### Frontend
- Vue.js 
- Tailwind CSS
- Vite

### Backend
- Laravel 
- PHP 

### Database
- PostgreSQL

### DevOps
- Docker
- Git & GitHub

---

## 📁 Project Structure

```
internhub/
│
├── backend/
├── frontend/
├── database/
├── docker/
├── docs/
├── .github/
│   └── workflows/
│
├── docker-compose.yml
├── README.md
├── LICENSE
└── .gitignore
```

---

## 🌿 Git Branching Strategy

InternHub follows a simplified **Git Flow** workflow.

### Main Branches

| Branch | Purpose |
|---------|---------|
| `main` | Stable production-ready version |
| `develop` | Main development branch |

### Feature Branches

- `feature/authentication`
- `feature/student-module`
- `feature/company-module`
- `feature/teacher-module`
- `feature/admin-module`
- `feature/ai-features`
- `feature/frontend-ui`
- `feature/devops`
- `feature/notifications`
- `feature/reports`

### Release & Maintenance

- `release/v1.0.0`
- `hotfix/*`
- `docs/*`

### Workflow

```
feature/*
      ↓
   develop
      ↓
 release/*
      ↓
     main
```

---

## 🚀 Getting Started

### Clone the repository

```bash
git clone https://github.com/YOUR_USERNAME/internhub-platform.git
cd internhub-platform
```

### Start Docker

```bash
docker compose up -d
```

### Backend

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

### Frontend

```bash
npm install
npm run dev
```

---

## 👥 Team

| Member | Role |
|--------|------|
| **Nour El Houda Sahli** | Project Manager & Full Stack Developer |
| **Wisal Nijad** | Full Stack Developer & DevOps Engineer |
| **Soukayna Zaidi** | Frontend Developer & Infrastructure Security Engineer |
| **Mohamed Reda Hachoum** | AI Engineer |
| **Ziad Chelouati** | Full Stack Developer & Application Security Engineer |
| **Moulay Youssef Bahedi** | Backend Developer & Quality Assurance Engineer |

---

## 📌 Roadmap

- [x] Project planning
- [x] Infrastructure setup
- [ ] Authentication
- [ ] Student Portal
- [ ] Company Portal
- [ ] Teacher Portal
- [ ] Administration Module
- [ ] AI Integration
- [ ] Notification System
- [ ] Reports & Analytics
- [ ] Testing & Quality Assurance
- [ ] Deployment

---

## 🤝 Contributing

1. Create a new branch from `develop`.
2. Implement your feature or bug fix.
3. Commit your changes with clear commit messages.
4. Open a Pull Request targeting `develop`.
5. Wait for code review before merging.


---



For questions, suggestions, or bug reports, please open an **Issue** or contact one of the project contributors.

---

<p align="center">
Developed with ❤️ by the InternHub Team
</p>

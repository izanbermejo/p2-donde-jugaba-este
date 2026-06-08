# Laravel 12 + Vue 3 SPA - ¿Dónde jugaba este?

Este proyecto es una aplicación web tipo SPA (Single Page Application) desarrollada con Laravel 12 como backend API y Vue 3 como frontend, orientada a un minijuego de fútbol donde los usuarios pueden adivinar jugadores y competir en rankings.

El objetivo del proyecto es aprender arquitectura moderna fullstack separando frontend y backend, aplicando autenticación, relaciones entre tablas, tests y componentes reutilizables.

---

##  Descripción del proyecto

Este proyecto consiste en una aplicación web interactiva centrada en el mundo del fútbol, donde los usuarios pueden:

- Jugar a diferentes minijuegos de adivinanzas futbolísticas  
- Competir en rankings y mejorar su puntuación  
- Registrarse e iniciar sesión para guardar su progreso
- Los administradores podran gestionar la base de daatos de los jugadores, clubes, paises, ligas y posiciones.

La aplicación está desarrollada como una **Single Page Application (SPA)**, combinando un backend robusto en Laravel con un frontend dinámico en Vue 3.

---

## 🚀 Características Principales

### Backend (Laravel 12)

- API RESTful para consumo desde Vue
- Autenticación con Sanctum
- Gestión de usuarios (login/registro)
- Sistema de partidas
- Rankings globales y por juego
- Relaciones entre jugadores, clubes, ligas y partidas
- Migraciones y seeders
- Validaciones backend
- Tests con PHPUnit

### Frontend (Vue 3)

- Composition API con `<script setup>`
- Pinia / composables
- Vue Router
- PrimeVue (DataTable, SelectButton, etc.)
- Filtros en frontend (sin backend)
- Layouts reutilizables
- Ranking dinámico
- Diseño responsive

---

## 🛠️ Requisitos

- PHP >= 8.2
- Composer
- Node.js >= 18
- MySQL

---

## ⚙️ Instalación

git clone <https://github.com/izanbermejo/p2-donde-jugaba-este>
cd p2-donde-jugaba-este

composer install
cp .env.example .env
php artisan key:generate

php artisan migrate:fresh --seed

npm install
npm run dev

php artisan serve

---

## 👤 Usuarios

Admin: admin@admin.com / 1234
User: user@user.com / 1234  

---

## 🎮 Proyecto

“¿Dónde jugaba este?” es un minijuego de fútbol donde los usuarios compiten adivinando jugadores, ganan puntos y suben en rankings.

---

## 🧪 Tests

vendor\bin\phpunit

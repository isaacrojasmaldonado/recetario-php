# 👨‍🍳 Mi Recetario Digital

Sistema moderno de gestión de recetas con diseño premium.

## 🛠️ Stack Tecnológico

| Capa | Tecnología |
|------|-----------|
| Backend | PHP 8.5 + Laravel 11 |
| Frontend | Vue 3 + Inertia.js |
| Estilos | CSS personalizado (Dark Mode) |
| Base de datos | MySQL |
| Build | Vite 6 |

## ✨ Funcionalidades

- ✅ CRUD completo de recetas
- ✅ Filtros por nombre, tipo, dificultad y fecha
- ✅ Categorías con colores personalizables
- ✅ Diseño oscuro premium con animaciones
- ✅ Doble confirmación al eliminar
- ✅ Modal animado para crear/editar
- ✅ Estadísticas en el header

## 🚀 Instalación

```bash
# 1. Clonar el repositorio
git clone https://github.com/TU_USUARIO/recetario-laravel.git
cd recetario-laravel

# 2. Instalar dependencias PHP
composer install

# 3. Instalar dependencias JS
npm install

# 4. Configurar entorno
cp .env.example .env
# Editar .env con tus datos de MySQL

# 5. Generar clave de app
php artisan key:generate

# 6. Crear tablas en la base de datos
php artisan migrate

# 7. Iniciar la aplicación
php artisan serve
npm run dev
```

## 📂 Estructura Principal

```
├── app/
│   ├── Http/Controllers/RecetaController.php
│   └── Models/ (Receta, Tiporeceta)
├── resources/
│   ├── js/Pages/Recipes/Index.vue
│   └── css/app.css
├── routes/web.php
└── database/migrations/
```

## 🌐 Uso

Abre tu navegador en `http://localhost:8000`

---

Creado con ❤️ usando Laravel + Vue.js

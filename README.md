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
- 🚀 **Script de inicio rápido**: Incluye un archivo `.bat` para levantar el sistema con un clic.

## 🚀 Instalación y Ejecución

### Opción 1: Ejecución Rápida (Recomendada para el evaluador)
Si tienes PHP, Composer y Node.js instalados en Windows:
1. Asegúrate de tener una base de datos MySQL llamada `recetario`.
2. Ejecuta el archivo `iniciar_recetario.bat`.
   *   *Este script instalará dependencias (si faltan), ejecutará migraciones y levantará el servidor automáticamente.*

### Opción 2: Instalación Manual
```bash
# 1. Clonar el repositorio
git clone https://github.com/isaacrojasmaldonado/recetario-php.git
cd recetario-php

# 2. Instalar dependencias
composer install
npm install

# 3. Configurar entorno
cp .env.example .env
# Configura tus credenciales de base de Datos en el .env

# 4. Preparar la base de datos
php artisan key:generate
php artisan migrate --seed

# 5. Iniciar la aplicación
php artisan serve
# En otra terminal:
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

@echo off
title Iniciando Recetario - Laravel + Vue
set PATH=%PATH%;C:\Users\isaac\php

echo ------------------------------------------
echo   INICIANDO EL SERVIDOR DEL RECETARIO
echo ------------------------------------------

:: Iniciar el backend de Laravel en una ventana nueva
echo [+] Iniciando Backend (Laravel)...
start cmd /k "php artisan serve"

:: Iniciar el frontend de Vite en una ventana nueva
echo [+] Iniciando Frontend (Vite/Vue)...
start cmd /k "npm run dev"

:: Esperar unos segundos para que cargue y abrir el navegador
echo [+] Abriendo navegador...
timeout /t 5 /nobreak > NUL
start http://localhost:8000

echo ------------------------------------------
echo   ¡Listo! El sistema se está ejecutando.
echo   No cierres las ventanas que se abrieron.
echo ------------------------------------------
pause

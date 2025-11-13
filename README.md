RM Moda — Sistema de Gestión y Tienda Online (Laravel + Sail)
Descripción General
RM Moda es una aplicación web desarrollada con el framework Laravel 10 y el entorno de ejecución Laravel Sail (Docker). El sistema permite gestionar productos, usuarios y pedidos, además de ofrecer una interfaz de tienda en línea para clientes registrados. El proyecto fue diseñado con arquitectura MVC y buenas prácticas de desarrollo web, integrando autenticación mediante Laravel Breeze, base de datos MySQL y un entorno de ejecución completamente contenedorizado.
Tecnologías Utilizadas
Tecnología	Descripción
Laravel 10	Framework principal del backend
Laravel Sail (Docker)	Entorno de desarrollo con contenedores
MySQL 8	Sistema gestor de base de datos relacional
Redis	Cache y cola de trabajos
Mailpit	Simulador de envío de correos locales
Tailwind CSS + Vite	Estilización moderna del frontend
PestPHP	Framework de pruebas unitarias y funcionales
PHP 8.3+	Lenguaje principal del backend
Node.js 20+ / NPM	Compilación de activos y dependencias de frontend
Requisitos Previos
- Docker Desktop instalado y corriendo.
- Composer instalado globalmente.
- Node.js y NPM (versión 18 o superior).
- Gi.
Instalación y Configuración
1.	Clonar o descomprimir el proyecto
unzip modalrm.zip
cd modalrm
2.	 Instalar dependencias del backend y frontend
composer install
npm install
3.	Configurar el entorno
cp .env.example .env
4.	Levantar los contenedores
./vendor/bin/sail up -d
5.	Generar la clave de aplicación
./vendor/bin/sail artisan key:generate
6.	Ejecutar migraciones (y seeders opcionales)
./vendor/bin/sail artisan migrate --seed
7.	Compilar los archivos de frontend
npm run dev   
Ejecución de Pruebas (PestPHP)
Para ejecutar todas las pruebas unitarias y funcionales:
./vendor/bin/sail test

Debe obtener un resultado similar a:
PASS  Tests\Feature\Auth\AuthenticationTest
PASS  Tests\Feature\Auth\RegistrationTest
Tests: 27 passed (0 failed)
Duration: XX.XXs
Comandos Útiles de Laravel Sail
Acción	Comando
Iniciar contenedores	./vendor/bin/sail up -d
Detener contenedores	./vendor/bin/sail down
Migrar base de datos	./vendor/bin/sail artisan migrate
Refrescar migraciones	./vendor/bin/sail artisan migrate:fresh --seed
Limpiar caché y configuraciones	./vendor/bin/sail artisan optimize:clear
Acceder al contenedor	./vendor/bin/sail shell
Ejecutar pruebas	./vendor/bin/sail test
Evidencias Recomendadas
Capturas de pantalla en el informe académico:
✅ Inicio de sesión exitoso
✅ Registro de usuario
✅ Panel de administración
✅ Carrito de compras
✅ Pedidos del usuario
✅ Reportes PDF/Excel
✅ Ejecución de tests Pest (todos aprobados)
Autor y Propósito
Desarrollado por: [Integrantes del grupo]
Carrera: Tecnologías de la Información y Comunicación
Propósito: Proyecto académico para evaluación de competencias en desarrollo backend y frontend con Laravel, Docker y buenas prácticas de ingeniería de software.

Fecha de entrega: Noviembre 2025

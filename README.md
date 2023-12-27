<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Run ICPC-UMSS

Este README proporciona instrucciones detalladas sobre cómo ejecutar y configurar una aplicación web desarrollada con Laravel. Asegúrate de seguir estos pasos para garantizar una instalación y ejecución exitosa.

## Requisitos Previos

Antes de comenzar, asegúrate de tener instalado lo siguiente: 

* PHP (7.4)
* Composer
* Node.js y npm
* MariaDB o cualquier otro sistema de gestión de datos compatible con Laravel

## Pasos para la configuración

1. Instalar dependecias: 

```
cd tis-icpc
composer install
```

2. Copiar el archivo de configuración: 

```
cp .env.example .env
```

3. Configurar la Base de Datos:

Abre el archivo .env en un editor de texto y configura los detalles de tu base de datos.

4. Generar la clave de la aplicacion:

```
php artisan key:generate
```

5. Ejecutar las migraciones y semillas: 

```
php artisan migrate --seed
```

6. Instalar dependencias de node.js:

```
npm install
```

7. Compilar los recursos frontend: 
```
npm run dev
```


## Ejecutar la aplicación. 

```
php artisan serve
```

La aplicación estará disponible en http://localhost:8000. Puedes acceder a ella utilizando un navegador web.

¡Listo! Has configurado y ejecutado con éxito tu aplicación Laravel.

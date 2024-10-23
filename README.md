<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Logo Laravel">
  </a>
</p>

<p align="center">
  <a href="https://github.com/laravel/framework/actions">
    <img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Estado de construcción">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Descargas totales">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/v/laravel/framework" alt="Última versión estable">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/l/laravel/framework" alt="Licencia">
  </a>
</p>

## Acerca de Laravel

Laravel es un framework de aplicaciones web con una sintaxis expresiva y elegante. Creemos que el desarrollo debe ser una experiencia agradable y creativa para ser realmente satisfactorio. Laravel elimina el dolor del desarrollo facilitando tareas comunes utilizadas en muchos proyectos web, tales como:

-   [Motor de enrutamiento simple y rápido](https://laravel.com/docs/routing).
-   [Potente contenedor de inyección de dependencias](https://laravel.com/docs/container).
-   Múltiples back-ends para almacenamiento de [sesión](https://laravel.com/docs/session) y [caché](https://laravel.com/docs/cache).
-   Expresivo e intuitivo [ORM de base de datos](https://laravel.com/docs/eloquent).
-   Base de datos agnóstica [migraciones de esquema](https://laravel.com/docs/migrations).
-   [Procesamiento robusto de tareas en segundo plano](https://laravel.com/docs/queues).
-   [Transmisión de eventos en tiempo real](https://laravel.com/docs/broadcasting).

Laravel es accesible, potente y proporciona las herramientas necesarias para aplicaciones grandes y robustas.

## Acerca de este proyecto

El siguiente proyecto es un sistema Kardex que maneja el inventario de una tienda de productos. El proyecto consta de 2 componentes principales:

## 1. Sistema Kardex

-   Proporciona operaciones CRUD (Crear, Leer, Actualizar, Borrar) para productos y movimientos de inventario.
-   Incluye los modelos de productos y movimientos de inventario.
-   Sigue las convenciones de enrutamiento de Laravel para las rutas CRUD.
-   Utiliza el sistema de validación de Laravel a través de los form requests.
-   Gestiona errores devolviendo respuestas JSON apropiadas.
-   Sigue las mejores prácticas de desarrollo utilizando una arquitectura limpia cómo lo es la arquitectura hexagonal y DDD(Domain Driven Design), separando la lógica de negocio de la lógica de presentación, en la cual agregué una carpeta SRC la cual contiene cada módulo (productos y movimientos de inventario), cada una contiene las 3 capas de la arquitectura las cuales son aplicación, dominio e infraestructura y se cargan en el composer.json en el autoload/psr-4.

## 2. Pruebas

-   Incluye pruebas unitarias para las rutas CRUD de productos y movimientos de inventario, cubriendo casos de éxito y error.
-   Utiliza el sistema de pruebas unitarias de Laravel para validar el comportamiento de cada módulo.

## Instalación

1. Clonamos el repositorio:
    ```sh
    git clone https://github.com/stiv120/kardex-system
    ```
2. Accedemos al directorio en la ruta donde lo descargamos:

    ```sh
    cd kardex-system
    ```

## Mediante docker

Dado que nuestra aplicación se ha integrado con Docker, si queremos usarlo, debemos tener instalado Docker Desktop en nuestra máquina, si no lo tienes, aquí tienes el enlace de descarga: https://www.docker.com/products/docker-desktop/ para que nuestra aplicación y los comandos que se dan a continuación funcionen.

## Iniciamos la aplicación

1. Ejecutamos el siguiente comando:

    ```sh
    docker compose up -d
    ```

Esto levantará el contenedor, con todos los servicios que necesitamos para ejecutar nuestra aplicación, incluido el servidor a través del cual accederemos a ella a través de este enlace: http://localhost:8081 para ver la aplicación.

2.  Accedemos a nuestro contenedor usando el siguiente comando:

    ```sh
    docker exec -it app bash
    ```

3.  Generamos la clave de la aplicación.

    ```sh
    php artisan key:generate
    ```

4.  Generamos la clave de pruebas.

    ```sh
    php artisan key:generate --env=testing
    ```

5.  Ejecutamos las migraciones de nuestra bd del sistema utilizando el siguiente comando:

    ```sh
    php artisan migrate
    ```

## Pruebas

1. Para ejecutar las pruebas, accedemos a nuestro contenedor mediante el siguiente comando:

    ```sh
    docker exec -it app bash
    ```

2. Una vez dentro de nuestro contenedor, ejecutamos el siguiente comando:

    ```sh
    php artisan test
    ```

    Esto ejecuta el observador de pruebas en modo interactivo.

3. Nota: Si los test nos fallan y sale mensaje de que no se puede conectar test_db, ejecutamos el siguiente comando:

    ```sh
    php artisan migrate --env=testing
    ```

Nos va a preguntar que si querems crearla colocmos la letra y, le damos enter y después Y volvemos a ejecutar el comando anterior para correr las pruebas y podemos comprobar que funcionan.

## Acceder a phpMyAdmin

Accedemos a través del siguiente enlace: http://localhost:8080, podemos ver que nuestras base de datos de pruebas y de producción se han creado correctamente.

## Acceso del sistema

Para probar las rutas de nuestro sistema lo he divido en dos partes, una es mediante APIs y la otra son para cuando se quiera usar con una interfaz del sistema.

## Mediante API

Nota: En mi caso, he utilizado Postman para probar las APIs. Si no lo tienes instalado, aquí tienes el enlace:
https://www.postman.com/downloads/

## Gestionar productos

1. Crear producto: Introducimos los datos requeridos en el cuerpo de la petición.
   Ruta de acceso: http://localhost:8081/api/products método POST
2. Obtener productos: http://localhost:8081/api/products método GET
3. Mostrar producto: http://localhost:8081/api/products/{id} método GET
4. Actualizar producto: Introducimos los datos que queremos actualizar.
   Ruta de acceso: http://localhost:8081/api/products/{id} método PUT
5. Borrar producto: http://localhost:8081/api/products/{id} método DELETE

## Gestionar inventarios

1. Crear movimiento de inventario: Introducimos los datos requeridos en el cuerpo de la petición.
   Ruta de acceso: http://localhost:8081/api/kardex-movements método POST
2. Obtener movimiento de inventarios: http://localhost:8081/api/kardex-movements método GET
3. Mostrar movimiento de inventario: http://localhost:8081/api/kardex-movements/{id} método GET
4. Actualizar movimiento de inventario: Introducimos los datos que queremos actualizar.
   Ruta de acceso: http://localhost:8081/api/kardex-movements/{id} método PUT
5. Borrar movimiento de inventario: http://localhost:8081/api/kardex-movements/{id} método DELETE

## Integración en web

## Gestionar productos

1. Crear producto: Introducimos los datos requeridos en el cuerpo de la petición.
   Ruta de acceso: http://localhost:8081/products método POST
2. Obtener productos: http://localhost:8081/products método GET
3. Mostrar producto: http://localhost:8081/products/{id} método GET
4. Actualizar producto: Introducimos los datos que queremos actualizar.
   Ruta de acceso: http://localhost:8081/products/{id} método PUT
5. Borrar producto: http://localhost:8081/products/{id} método DELETE

## Gestionar inventarios

1. Crear movimiento de inventario: Introducimos los datos requeridos en el cuerpo de la petición.
   Ruta de acceso: http://localhost:8081/kardex-movements método POST
2. Obtener movimiento de inventarios: http://localhost:8081/kardex-movements método GET
3. Mostrar movimiento de inventario: http://localhost:8081/kardex-movements/{id} método GET
4. Actualizar movimiento de inventario: Introducimos los datos que queremos actualizar.
   Ruta de acceso: http://localhost:8081/kardex-movements/{id} método PUT
5. Borrar movimiento de inventario: http://localhost:8081/kardex-movements/{id} método DELETE

## Sin Docker

Si no queremos usar docker o no lo tenemos instalado podemos usar de igual manera la aplicación de forma local, eso sí para la base de datos se necesita el servicio de mysql, ya sea mediante el xampp u otra herramienta que nos permita gestionar nuestra base de datos para conectarse con la aplicación.

1. primero usamos el siguiente comando

    ```sh
    composer install
    ```

2. Copiamos el archivo .env.example a .env

    ```sh
    cp .env.example .env
    ```

3. Generamos la clave de la aplicación.

    ```sh
    php artisan key:generate
    ```

4. Generamos la clave de pruebas.

    ```sh
    php artisan key:generate --env=testing
    ```

5. Ejecutamos las migraciones utilizando el siguiente comando:

    ```sh
    php artisan migrate
    ```

6. Debemos descomentar las variables de la conexión a nuestra bd local en el .env y en el .env.testing y comentar las de docker.
    ```sh
    # DB_HOST=tuiplocal
    # DB_PASSWORD=
    ```

## Iniciamos la aplicación

1. Para iniciar nuestra aplicación, ejecutamos el siguiente comando:

    ```sh
    php artisan serve
    ```

    Esto correra el servidor en: http://localhost:8081 para ver la aplicación.

## Pruebas

1.  Para ejecutar las pruebas ejecutamos el siguiente comando:

    ```sh
    php artisan test
    ```

Esto ejecuta el observador de pruebas en modo interactivo.

3.  Nota: Si los test nos fallan y sale mensaje de que no se puede conectar test_db, ejecutamos el siguiente comando:

    ```sh
    php artisan migrate --env=testing
    ```

Nos va a preguntar que si querems crearla colocmos la letra y, le damos enter y después volvemos a ejecutar el comando anterior para correr las pruebas y podemos comprobar que funcionan.

## Acceso del sistema

Para probar las rutas de nuestro sistema lo he divido en dos partes, una es mediante APIs y la otra son para cuando se quiera usar con una interfaz del sistema.

## Mediante API

Nota: En mi caso, he utilizado Postman para probar las APIs. Si no lo tienes instalado, aquí tienes el enlace:
https://www.postman.com/downloads/

## Gestionar productos

1. Crear producto: Introducimos los datos requeridos en el cuerpo de la petición.
   Ruta de acceso: http://127.0.0.1:8000/api/products método POST
2. Obtener productos: http://127.0.0.1:8000/api/products método GET
3. Mostrar producto: http://127.0.0.1:8000/api/products/{id} método GET
4. Actualizar producto: Introducimos los datos que queremos actualizar.
   Ruta de acceso: http://127.0.0.1:8000/api/products/{id} método PUT
5. Borrar producto: http://127.0.0.1:8000/api/products/{id} método DELETE

## Gestionar inventarios

1. Crear movimiento de inventario: Introducimos los datos requeridos en el cuerpo de la petición.
   Ruta de acceso: http://127.0.0.1:8000/api/kardex-movements método POST
2. Obtener movimiento de inventarios: http://127.0.0.1:8000/api/kardex-movements método GET
3. Mostrar movimiento de inventario: http://127.0.0.1:8000/api/kardex-movements/{id} método GET
4. Actualizar movimiento de inventario: Introducimos los datos que queremos actualizar.
   Ruta de acceso: http://127.0.0.1:8000/api/kardex-movements/{id} método PUT
5. Borrar movimiento de inventario: http://127.0.0.1:8000/api/kardex-movements/{id} método DELETE

## Integración en web

## Gestionar productos

1. Crear producto: Introducimos los datos requeridos en el cuerpo de la petición.
   Ruta de acceso: http://127.0.0.1:8000/products método POST
2. Obtener productos: http://127.0.0.1:8000/products método GET
3. Mostrar producto: http://127.0.0.1:8000/products/{id} método GET
4. Actualizar producto: Introducimos los datos que queremos actualizar.
   Ruta de acceso: http://127.0.0.1:8000/products/{id} método PUT
5. Borrar producto: http://127.0.0.1:8000/products/{id} método DELETE

## Gestionar inventarios

1. Crear movimiento de inventario: Introducimos los datos requeridos en el cuerpo de la petición.
   Ruta de acceso: http://127.0.0.1:8000/kardex-movements método POST
2. Obtener movimiento de inventarios: http://127.0.0.1:8000/kardex-movements método GET
3. Mostrar movimiento de inventario: http://127.0.0.1:8000/kardex-movements/{id} método GET
4. Actualizar movimiento de inventario: Introducimos los datos que queremos actualizar.
   Ruta de acceso: http://127.0.0.1:8000/kardex-movements/{id} método PUT
5. Borrar movimiento de inventario: http://127.0.0.1:8000/kardex-movements/{id} método DELETE

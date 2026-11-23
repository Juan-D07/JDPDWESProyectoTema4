
# Aplicación de Proyecto Tema 4
## 1. Descripción
Esta aplicación web está desarrollada en PHP y establecemos una conexion con una base de datos.
Podemos ver Objetos PDO, ejecuciones de sentencias SQL, Transacciones y mucho mas  

## 2. Requisitos
- PHP 8.3 o superior.
- Un servidor web, como Apache, o el servidor de desarrollo integrado de PHP.
- MySQL si la aplicación utiliza una base de datos.
## 3. Instalación
Clonar el repositorio:
`git clone https://github.com/Juan-D07/JDPDWESProyectoTema4`

Acceder a la carpeta del proyecto:
`cd JDPDWESProyectoTema4`
*Configurar la conexión a la base de datos en config.php y ejecuta los sricpts de creacion y carga.*

Iniciar el servidor de desarrollo de PHP:
`php -S localhost:8000`

## 4. Uso
Una vez iniciado el servidor:

Abrir un navegador web.
`Acceder a http://localhost:8000.`
Crear nuevas tareas y gestionar las existentes.
## 5. Estructura del proyecto

```text
JDPDWESProyectoTema4/
├── indexProyectoTema4.php
├── .htaccess
├── config
├── codigoPHP
├── mostrarcodigo
├── scriptDB
├── webroot
├── tmp
├── error
└── core
```

## 6. Funcionalidades
- Crear conexiones PDO
- Ejecutar sentencias SQL (select, insert, update y delete)
- Iniciar transacciones
- Usar consultas preparadas
- Importacion y exportacion en JSON y XML
## 7. Contribuciones
Las contribuciones son bienvenidas. Para colaborar, se recomienda:

Crear un fork del repositorio.
Crear una rama para los cambios.
Realizar las modificaciones necesarias.
Guardar los cambios mediante un commit descriptivo.
Enviar una solicitud de cambios (pull request) para su revisión.
8. Licencia
Este proyecto puede distribuirse bajo la licencia MIT si el propietario decide adoptarla. Antes de publicar el proyecto, debe añadirse el archivo de licencia correspondiente y comprobar que se cumplen sus condiciones.

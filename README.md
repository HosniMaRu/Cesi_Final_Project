# POSIT

## Descripcion

Pagina web en la que te registras y puedes añadir tareas pendientes, modificarlas y eliminarlas.

## Entregas

[Primera entrega](./doc/primera%20entrega/README.md) - README

[Segunda entrega](./doc/segunda%20entrega/README.md) - README

## Demo

[Proyecto] - https://cesifinalproject.herokuapp.com/

## Repositorio

[Github] - https://github.com/HosniMaRu/Cesi_Final_Project.git

## Requisitos

[Requisitos](composer.json) - Composer

## Lenguajes usados

![Requisitos](./doc/codigos.png)

## Componentes

- [Index](./index.html) - Pagina principal.

  Pagina de inicio donde te permite elegir entre login y registrarse.

- [Login](./login/login.html) - Pagina login.

  Pagin de login, donde te permite loguearte o volver a la pagina principal.

- [Register](./registro/registro.html) - Pagina registro.

  Pagin de registro, donde te permite registrase o volver a la pagina principal.

- [Dashboard](./dashboard/dashboard.html) - Pagina dashboard.

  Pagin dashboard, donde se cargan todas las tareas pendientes del usuario. Puedes modificar cada tarea, eliminarla, o desloguearte.

- [Detalle](./detalle/detalle.html) - Pagina detalle.

  Pagina detalle donde se cargara la tarea seleccionada que deseas modificar, y un boton para volver al dashboard.

- [Footer](./footer/footer.html) -Footer.

  Componente que cargamos en cada uno de los componentes anteriores, para cargar el footer y no repetirlo constantemente.

## Base de datos

[BBDD](./doc/DDBB.sql) - Export de la base de datos: phpMyAdmin SQL Dump

- Base de datos usada: phpmyadmin
- Nombre DDBB: sql11502507
- Tabla usuarios_temp. Donde guardamos los usuarios registrados.
- Tabla usuarios. Registra los usuarios que confirman el mail de confirmación.
- Tabla listas. Asigna id a los usuarios y recoge la id de sus elementos guardados.(las tareas).
- Tabla listaobjetos. Guarda las tareas correspondientes de cada usuario.

## A destacar

- Los puntos fuertes de esta pagina web es la gestion con back-end para poder guardar y recopilar todas las tareas registradas de cada usuario.

- Añadido logOut, donde se borra el token del usuario de la BBDD y las cookies.

- La organizacion de la parte servidor se debe mejorar, deberia tener un archivo php para cada tabla de la BBDD, no uno por cada componente que necessita interactuar con la BBDD.

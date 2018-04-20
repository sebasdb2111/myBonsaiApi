MyBonsai API REST
=================
Api Rest desarrollada en en PHP con el Framework Symfony la cual lleva la lógica para el cliente (en desarrollo)


IMPORTAR BASE DE DATOS
----------------------
En la raíz del proyecto podrás encontrar el archivo myBonsai.sql el cual deberás importar.

COMPOSER
--------
Instalar dependencias ejecutando el siguiente comando
+ composer update

Te pedirá tus datos de configuración de la base de datos

ARRANCAR PROYECTO
-----------------
Desde terminal, dirígete a la raíz del proyecto y ejecuta el siguiente comando
+ php bin/console server:run


PETICIONES
----------
 LOGIN
+ localhost:8000/login
+ Json => {"email":"sebas@sebas.com","password":"sebas"}

NUEVO USUARIO
+ localhost:8000/user/new
+ json => {"username":"sebas","email":"sebas@sebas.com","password":"sebas","nombre":"Sebastian","apellidos":"Diez Buades","fechaNacimiento":"21-11-1986"}

EDITAR USUARIO
+ localhost:8000/user/edit
+ Authorization => token generado con la peticion de login
+ En esta petición solo es necesario pasar los campos que se desean editar, los campos posibles son: nombre, apellidos, fechaNacimiento, imgUser y password
+ json => {"nombre":"Sebastian","apellidos":"Diez","fechaNacimiento":"07-11-1987"}

USER BONSAI
+ localhost:8000/userBonsai/
+ Authorization => token generado con la peticion de login

NUEVO USER BONSAI
+ localhost:8000/userBonsai/new/
+ Authorization => token generado con la peticion de login
+ json => {"idBonsai":"2","alias": "mi manzano", "edad": "6","fechaAdquisicion": "2018-02-18","descripcion": "este es mi segundo bonsai"}

DETALLE USER BONSAI
+ localhost:8000/userBonsai/detail/{id}
+ Authorization => token generado con la peticion de login

EDITAR USER BONSAI
+ localhost:8000/userBonsai/edit/{id}
+ Authorization => token generado con la peticion de login
+ json => {"idBonsai":"2","alias": "mi manzano editado", "edad": "6","fechaAdquisicion": "2018-02-18","descripción": "este es mi segundo bonsai editado"}

BORRAR USER BONSAI
+ localhost:8000/userBonsai/remove/{id} <= Este Id es el IdUserBonsai
+ Authorization => token generado con la peticion de login

LOG CUIDADOS
+ localhost:8000/logCuidados/{id} <= Este Id es el IdUserBonsai
+ Authorization => token generado con la peticion de login

NUEVO LOG CUIDADOS
+ localhost:8000/logCuidados/new/{id} <= Este Id es el IdUserBonsai
+ Authorization => token generado con la peticion de login
+ json => {"cuidado":"regar","createdAt": "2018-04-10"}

BORRAR LOG CUIDADOS
+ localhost:8000/logCuidados/remove/{id} <= Este Id es el IdLogCuidados
+ Authorization => token generado con la peticion de login

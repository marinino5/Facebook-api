
# FACEBOOK API REST

<p align="center">
  <h2 align="center">FACEBOOK API REST</h2>
</p>

<p align="center">
  <strong>Proyecto de Arquitectura y Desarrollo Backend</strong><br>
  API REST para gestionar publicaciones, fotografías, comentarios y reacciones mediante Laravel.
</p>

---

## 🌐 Descripción del proyecto

**Facebook API REST** es una aplicación backend desarrollada con **Laravel 13** como parte de la asignatura Arquitectura y Desarrollo Backend de la Universidad Autónoma de Bucaramanga (UNAB).

El proyecto simula las interacciones básicas de una red social, permitiendo crear publicaciones con fotografías, consultar contenido, agregar comentarios, registrar reacciones de «Me gusta» y eliminar publicaciones.

La aplicación utiliza una arquitectura REST, el ORM Eloquent y una base de datos SQLite. Las operaciones se realizan mediante peticiones HTTP y las respuestas se entregan en formato JSON.

---

## 👩‍💻 Autoría

<table>
  <tr>
    <td>
      <img src="https://github.com/marinino5.png" width="130" alt="Perfil de GitHub">
    </td>
    <td>
      <strong>Autora:</strong> Mariana Niño Solano<br>
      <strong>Universidad:</strong> Universidad Autónoma de Bucaramanga<br>
      <strong>Asignatura:</strong> Arquitectura y Desarrollo Backend<br>
      <strong>Docente:</strong> Fabián Enrique Suárez Carvajal<br>
      <strong>Proyecto:</strong> Facebook API REST
    </td>
  </tr>
</table>

---

## ⚡ Enfoque del proyecto

**Facebook API REST** está orientado al desarrollo de servicios backend para la comunicación entre aplicaciones mediante HTTP.

El taller permite aplicar conceptos de enrutamiento, controladores, modelos Eloquent, relaciones entre tablas, validación de datos y almacenamiento de archivos.

Su funcionamiento se comprobó mediante pruebas realizadas con Bruno, validando las operaciones y los códigos de respuesta HTTP correspondientes.

---

## 🔗 Funcionalidades y endpoints

| Método | Endpoint | Funcionalidad |
|---|---|---|
| POST | `/api/posts` | Crear publicación con imágenes |
| GET | `/api/posts` | Listar publicaciones |
| GET | `/api/posts/{id}` | Consultar publicación |
| POST | `/api/posts/{id}/comments` | Agregar comentario |
| GET | `/api/posts/{id}/comments` | Listar comentarios |
| POST | `/api/posts/{id}/like` | Dar Me gusta |
| DELETE | `/api/posts/{id}` | Eliminar publicación |

---

## 🛠️ Tecnologías utilizadas

- **Laravel 13:** framework backend.
- **PHP 8.5:** lenguaje de programación utilizado.
- **SQLite:** base de datos.
- **Eloquent ORM:** modelos y relaciones.
- **Bruno:** pruebas de peticiones HTTP.
- **Postman Collection v2.1:** formato de exportación de pruebas.
- **Git y GitHub:** control de versiones.

---

## 🚀 Ejecución del proyecto

Clonar el repositorio e instalar las dependencias:

```bash
git clone https://github.com/marinino5/Facebook-api.git
cd Facebook-api
composer install
```

Configurar el entorno y la base de datos:

```bash
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
php artisan storage:link
```

Iniciar el servidor:

```bash
php artisan serve
```

La API estará disponible en:

`http://127.0.0.1:8000/api/posts`

La configuración de la base de datos debe utilizar `DB_CONNECTION=sqlite`.

---

## 🧪 Pruebas de la API

Las funcionalidades fueron verificadas con **Bruno**, obteniendo respuestas HTTP `200`, `201`, `204`, `404` y `422`.

El repositorio incluye:

- `bruno-tests/`: colección con las ocho peticiones del taller.
- `facebook-api-postman-collection.json`: colección exportada en formato Postman v2.1.

Para probar la carga de fotografías, se deben seleccionar imágenes JPG o PNG de máximo 2 MB por archivo.

---

<p align="center">
  <strong>FACEBOOK API REST</strong><br>
  Desarrollo de servicios REST con Laravel.<br>
  Universidad Autónoma de Bucaramanga — UNAB
</p>

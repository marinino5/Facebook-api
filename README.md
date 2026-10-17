# FACEBOOK API REST

<p align="center">
  <strong>Proyecto de Arquitectura y Desarrollo Backend</strong>
</p>

<p align="center">
  Universidad Autónoma de Bucaramanga — UNAB
</p>

API REST desarrollada con **Laravel 13**, que simula las funcionalidades de una red social mediante la gestión de publicaciones, imágenes, comentarios, reacciones y autenticación de usuarios.

---

## 👩‍💻 Autora

<img src="https://github.com/marinino5.png" width="100" alt="Perfil de GitHub">

**Mariana Niño Solano**  
Universidad Autónoma de Bucaramanga — UNAB  
**Docente:** Fabián Enrique Suárez Carvajal

---

## 🚀 Desarrollo del proyecto

### Taller 1 — Desarrollo de la API REST

Construcción de la API mediante Laravel, rutas, controladores, modelos Eloquent y relaciones entre tablas. Implementación de publicaciones con imágenes, comentarios, reacciones y operaciones CRUD, utilizando SQLite.

### Taller 2 — Autenticación y documentación

Integración de **Laravel Sanctum** para el registro, inicio de sesión y protección de endpoints. Implementación del versionado `/api/v1`, pruebas con Bruno y documentación automática mediante Scribe.

### Taller 3 — Contenerización y despliegue

Configuración de **Docker y Docker Compose**, integración de PostgreSQL y despliegue de la API en Render.

Se implementaron migraciones automáticas, variables de entorno y conexión HTTPS. Las pruebas en Bruno confirmaron respuestas **200 OK y 201 Created**, además de la persistencia de publicaciones en PostgreSQL.

---

## 🛠️ Tecnologías

**Laravel 13 · PHP 8.5 · SQLite · PostgreSQL · Docker · Sanctum · Scribe · Bruno · Render · GitHub**

---

## 🌐 API desplegada

**Plataforma:** Render Cloud  
**Base de datos:** PostgreSQL 18

**URL pública:** https://facebook-api-ydrl.onrender.com

**Consultar publicaciones:** https://facebook-api-ydrl.onrender.com/api/posts

**Ejecución local con Docker:**

```bash
docker compose up -d --build
```

---

<p align="center">
  <strong>FACEBOOK API REST</strong><br>
  Arquitectura y Desarrollo Backend · UNAB
</p>
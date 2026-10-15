# Authenticating requests

To authenticate requests, include an **`Authorization`** header with the value **`"Bearer {TOKEN_SANCTUM}"`**.

All authenticated endpoints are marked with a `requires authentication` badge in the documentation below.

Para obtener un token de autenticación, realiza una petición POST a `/api/login` o `/api/v1/login` con tu correo y contraseña. Copia el campo `token` de la respuesta y utilízalo como Bearer Token en las rutas protegidas.

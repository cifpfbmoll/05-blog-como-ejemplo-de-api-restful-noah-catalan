# Capturas de Pruebas - Blog API RESTful
**Autor:** Noah Catalán  
**Fecha:** 19 de Noviembre 2025

## 📸 Capturas de Pantalla

### GET /posts - Listado de Posts
![GET /posts](GET_posts.png)
*Captura mostrando el listado completo de posts en formato JSON*

### GET /posts/search - Búsqueda por término
![GET por término](GET%20por%20termino.png)
*Captura mostrando la funcionalidad de búsqueda de posts*

---

## 📸 Pruebas Realizadas

A continuación se documentan las pruebas realizadas sobre la API durante el proceso de instalación y verificación.

---

### 1. Verificación de PHP y Composer

**Versión de PHP instalada:**
```
PHP 8.2.12 (cli) (built: Oct 24 2023 21:15:15) (ZTS Visual C++ 2019 x64)
```

**Versión de Composer:**
```
Composer version 2.8.12 2025-09-19 13:41:59
```

---

### 2. Instalación de Dependencias

Se ejecutó el comando `composer install --no-interaction` para instalar todas las dependencias del proyecto.

**Resultado:** ✅ Exitoso - Se instalaron 33 paquetes incluyendo CodeIgniter 4 v4.6.3

---

### 3. Ejecución de Migraciones

**Comando ejecutado:**
```powershell
php spark migrate
```

**Resultado:**
```
CodeIgniter v4.6.3 Command Line Tool - Server Time: 2025-11-19 19:51:34 UTC+00:00

Running all new migrations...
Migrations complete.
```

✅ La tabla `posts` se creó correctamente en la base de datos SQLite.

---

### 4. Inicio del Servidor

**Comando ejecutado:**
```powershell
php spark serve
```

**Resultado:**
```
CodeIgniter development server started on http://localhost:8080
Press Control-C to stop.
```

✅ Servidor funcionando correctamente en `http://localhost:8080`

---

### 5. Prueba GET /posts - Listar todos los posts

**Endpoint:** `GET http://localhost:8080/posts`

**Resultado:**
```json
[
    {
        "id": 1,
        "title": "Mi Primer Post ACTUALIZADO",
        "content": "Este es el contenido de mi primer post usando CodeIgniter 4 y SQLite.",
        "category": "Desarrollo",
        "tags": "[\"php\",\"codeigniter\",\"api\"]",
        "created_at": "2025-11-05 12:49:55",
        "updated_at": "2025-11-05 12:49:55"
    },
    {
        "id": 3,
        "title": "Mi Primer Post en CI4",
        "content": "Este es el contenido de mi primer post usando CodeIgniter 4 y SQLite. Estoy aprendiendo a crear APIs RESTful.",
        "category": "Desarrollo",
        "tags": "[\"php\",\"codeigniter\",\"api\",\"rest\"]",
        "created_at": "2025-11-05 12:57:51",
        "updated_at": "2025-11-05 12:57:51"
    }
]
```

✅ **Estado HTTP:** 200 OK  
✅ Devuelve correctamente el listado de posts en formato JSON

---

### 6. Prueba POST /posts - Crear un nuevo post

**Endpoint:** `POST http://localhost:8080/posts`

**Cuerpo de la petición (test_post.json):**
```json
{
  "title": "Post de prueba Noah",
  "content": "Este es un post de prueba creado por Noah Catalan para verificar el funcionamiento de la API",
  "category": "Pruebas",
  "tags": ["test", "noah", "api"]
}
```

**Comando ejecutado:**
```powershell
Invoke-WebRequest -Uri http://localhost:8080/posts -Method POST -InFile "test_post.json" -ContentType "application/json; charset=utf-8"
```

**Resultado:**
```json
{
    "id": 4,
    "title": "Post de prueba Noah",
    "content": "Este es un post de prueba creado por Noah Catalan para verificar el funcionamiento de la API",
    "category": "Pruebas",
    "tags": "[\"test\",\"noah\",\"api\"]",
    "created_at": "2025-11-19 19:53:51",
    "updated_at": "2025-11-19 19:53:51"
}
```

✅ **Estado HTTP:** 201 Created  
✅ El post se creó correctamente con ID 4

---

### 7. Prueba GET /posts/{id} - Obtener un post específico

**Endpoint:** `GET http://localhost:8080/posts/4`

**Comando ejecutado:**
```powershell
Invoke-WebRequest -Uri http://localhost:8080/posts/4 -Method GET
```

**Resultado:**
```json
{
    "id": 4,
    "title": "Post de prueba Noah",
    "content": "Este es un post de prueba creado por Noah Catalan para verificar el funcionamiento de la API",
    "category": "Pruebas",
    "tags": "[\"test\",\"noah\",\"api\"]",
    "created_at": "2025-11-19 19:53:51",
    "updated_at": "2025-11-19 19:53:51"
}
```

✅ **Estado HTTP:** 200 OK  
✅ Devuelve correctamente el post con ID 4

---

### 8. Prueba GET /posts/search - Buscar posts

**Endpoint:** `GET http://localhost:8080/posts/search?term=noah`

**Comando ejecutado:**
```powershell
Invoke-WebRequest -Uri "http://localhost:8080/posts/search?term=noah" -Method GET
```

**Resultado:**
```json
[
    {
        "id": 4,
        "title": "Post de prueba Noah",
        "content": "Este es un post de prueba creado por Noah Catalan para verificar el funcionamiento de la API",
        "category": "Pruebas",
        "tags": "[\"test\",\"noah\",\"api\"]",
        "created_at": "2025-11-19 19:53:51",
        "updated_at": "2025-11-19 19:53:51"
    }
]
```

✅ **Estado HTTP:** 200 OK  
✅ La búsqueda funciona correctamente, encuentra posts que contienen "noah"

---

## 🎯 Resumen de Pruebas

| Endpoint | Método | Estado | Resultado |
|----------|--------|--------|-----------|
| `/posts` | GET | ✅ 200 OK | Lista todos los posts |
| `/posts` | POST | ✅ 201 Created | Crea un nuevo post |
| `/posts/4` | GET | ✅ 200 OK | Obtiene post específico |
| `/posts/search?term=noah` | GET | ✅ 200 OK | Busca posts correctamente |

---

## 🐛 Problemas Encontrados

### 1. Extensión SQLite3 no habilitada
- **Síntoma:** Error al ejecutar migraciones
- **Solución:** Descomentar `extension=sqlite3` en `php.ini`

### 2. Error de encoding UTF-8 en PowerShell
- **Síntoma:** Error 500 al crear posts con PowerShell
- **Solución:** Usar archivo JSON con `-InFile` en lugar de pasar el JSON directamente

---

## ✅ Conclusiones

- La API funciona correctamente
- Todos los endpoints responden como se espera
- La validación de datos está funcionando
- La base de datos SQLite se creó y funciona sin problemas
- El proyecto está listo para usar

**Fecha de las pruebas:** 19 de Noviembre de 2025  
**Realizado por:** Noah Catalán

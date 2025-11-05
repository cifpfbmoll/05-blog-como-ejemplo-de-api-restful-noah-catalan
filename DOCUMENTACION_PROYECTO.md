# Documentación del Proyecto: API RESTful para Blog con CodeIgniter 4

## Índice
1. [Introducción](#introducción)
2. [Stack Tecnológico](#stack-tecnológico)
3. [Proceso de Desarrollo](#proceso-de-desarrollo)
4. [Endpoints de la API](#endpoints-de-la-api)
5. [Pruebas](#pruebas)
6. [Reflexión Final](#reflexión-final)

---

## Introducción

Este proyecto consiste en la creación de una **API RESTful** para gestionar posts de un blog. El objetivo principal es aprender los fundamentos de **CodeIgniter 4**, el manejo de bases de datos con **SQLite** y los principios de las APIs REST.

### Objetivos del Proyecto
- ✅ Construir endpoints CRUD (Create, Read, Update, Delete) para posts
- ✅ Implementar validación de datos
- ✅ Manejar respuestas HTTP apropiadas
- ✅ Implementar funcionalidad de búsqueda
- ✅ Documentar todo el proceso de desarrollo

---

## Stack Tecnológico

- **Framework**: CodeIgniter 4 (v4.6.3)
- **Base de Datos**: SQLite 3
- **Lenguaje**: PHP 8.3.6
- **Gestor de Dependencias**: Composer

### ¿Por qué este stack?

**CodeIgniter 4**: Es un framework PHP moderno, ligero y con excelente documentación. Perfecto para aprender los conceptos de MVC y desarrollo de APIs.

**SQLite**: Es una base de datos que se almacena en un solo archivo, no requiere un servidor de BD separado, lo que la hace ideal para desarrollo y proyectos pequeños.

---

## Proceso de Desarrollo

### Paso 0: Configuración Inicial del Entorno

#### ¿Qué es Composer?
**Composer** es el gestor de dependencias estándar para PHP. Nos permite:
- Instalar librerías y frameworks de forma automática
- Gestionar versiones de dependencias
- Autocargar clases automáticamente

Para instalar CodeIgniter 4, ejecutamos:
```bash
composer create-project codeigniter4/appstarter .
```

#### ¿Qué es Spark?
**Spark** es la herramienta de línea de comandos de CodeIgniter 4. Nos permite:
- Generar código automáticamente (controladores, modelos, migraciones)
- Ejecutar migraciones de base de datos
- Iniciar el servidor de desarrollo
- Ejecutar tareas personalizadas

#### ¿Qué hace `spark serve`?
Este comando inicia un servidor de desarrollo local en `http://localhost:8080`. Es perfecto para desarrollo, pero NO debe usarse en producción.

```bash
php spark serve
```

---

### Paso 1: Configurar la Base de Datos (SQLite)

#### ¿Qué es el archivo .env?
El archivo `.env` (environment) almacena configuraciones sensibles y específicas del entorno:
- Credenciales de base de datos
- Claves API
- Configuraciones de desarrollo/producción

**¿Por qué usar .env?**
- **Seguridad**: Las credenciales no se suben al repositorio (está en .gitignore)
- **Portabilidad**: Cada desarrollador puede tener su propia configuración
- **Flexibilidad**: Fácil cambiar entre entornos (desarrollo, pruebas, producción)

#### Configuración SQLite

Creamos el archivo `.env` desde `env`:
```bash
cp env .env
```

Configuración en `.env`:
```ini
CI_ENVIRONMENT = development
app.baseURL = 'http://localhost:8080/'

database.default.hostname = localhost
database.default.database = /ruta/absoluta/writable/database/blog.db
database.default.DBDriver = SQLite3
```

**¿Por qué SQLite?**
- ✅ Un solo archivo, fácil de respaldar
- ✅ No requiere instalación de servidor
- ✅ Perfecto para desarrollo y prototipos
- ✅ Suficiente para aplicaciones pequeñas/medianas

---

### Paso 2: Crear la Estructura de la Tabla (Migraciones)

#### ¿Qué es una Migración?
Una **migración** es un archivo PHP que describe cambios en la estructura de la base de datos. Es como un "control de versiones" para tu BD.

**Ventajas de las migraciones:**
- 📝 Historial de cambios en la BD
- 🔄 Fácil revertir cambios (rollback)
- 👥 Compartir estructura con el equipo
- 🚀 Desplegar cambios en producción de forma controlada

#### Crear la migración
```bash
php spark make:migration CreatePostsTable
```

#### Métodos up() y down()

**`up()`**: Define QUÉ hacer (crear tabla, agregar columnas, etc.)
**`down()`**: Define CÓMO revertirlo (eliminar tabla, quitar columnas, etc.)

#### Código de la migración

Ver archivo: `app/Database/Migrations/2025-11-05-122918_CreatePostsTable.php`

La tabla incluye:
- `id`: INT, autoincremental, clave primaria
- `title`: VARCHAR(255)
- `content`: TEXT
- `category`: VARCHAR(100)
- `tags`: TEXT (almacenamos JSON)
- `created_at`: DATETIME
- `updated_at`: DATETIME

#### Ejecutar la migración
```bash
php spark migrate
```

---

### Paso 3: Crear el Modelo

#### ¿Qué es un Modelo en MVC?
El **Modelo** es la capa que interactúa con la base de datos. Su responsabilidad es:
- 📊 Consultar datos
- ✏️ Insertar/actualizar/eliminar registros
- ✅ Validar datos
- 🔄 Transformar datos

**Patrón MVC:**
- **Model**: Maneja datos y lógica de negocio
- **View**: Presenta datos al usuario (en APIs, JSON)
- **Controller**: Coordina Model y View

#### Crear el modelo
```bash
php spark make:model Post --suffix
```

#### Propiedades importantes del modelo

**`$allowedFields`**: ¡MUY IMPORTANTE para seguridad!
- Define qué campos pueden ser asignados masivamente
- Previene **Mass Assignment Vulnerability**
- Sin esto, un atacante podría modificar campos sensibles

**Ejemplo de vulnerabilidad:**
```php
// Sin $allowedFields protegido
$model->insert($request->getJSON(true));
// Un atacacker podría enviar: {"title": "Hola", "is_admin": true}
```

**`$useTimestamps = true`**: 
- CI4 automáticamente actualiza `created_at` y `updated_at`
- ¡No necesitas hacerlo manualmente!

Ver archivo: `app/Models/PostModel.php`

---

### Paso 4: Crear el Controlador

#### ¿Qué es un Controlador?
El **Controlador** es el intermediario entre el usuario (peticiones HTTP) y el modelo (datos). Su trabajo es:
- 📥 Recibir peticiones
- ✅ Validar datos
- 🔄 Llamar al modelo
- 📤 Devolver respuestas

#### Crear el controlador
```bash
php spark make:controller Posts --restful
```

#### Controller vs ResourceController

**`Controller`**: Controlador básico de CI4
**`ResourceController`**: Controlador especializado para APIs REST

**Ventajas de ResourceController:**
- ✅ Métodos helper para respuestas JSON: `respond()`, `respondCreated()`, `fail()`
- ✅ Manejo automático de códigos HTTP
- ✅ Métodos predefinidos: `index()`, `show()`, `create()`, `update()`, `delete()`
- ✅ Propiedad `$format` para especificar formato de respuesta

**`$modelName`**: Especifica qué modelo usar. Accesible como `$this->model`
**`$format = 'json'`**: Define el formato de respuesta

Ver archivo: `app/Controllers/Posts.php`

---

### Paso 5: Configurar las Rutas

Las rutas conectan URLs con métodos de controladores.

Archivo: `app/Config/Routes.php`

```php
// API Routes
$routes->get('posts/search', 'Posts::search');
$routes->resource('posts');
```

#### ¿Qué hace `$routes->resource('posts')`?

Esta **línea mágica** crea automáticamente todas las rutas RESTful:

| Método HTTP | URL | Controlador::Método | Acción |
|-------------|-----|---------------------|--------|
| GET | /posts | Posts::index() | Listar todos |
| GET | /posts/1 | Posts::show(1) | Ver uno |
| POST | /posts | Posts::create() | Crear nuevo |
| PUT/PATCH | /posts/1 | Posts::update(1) | Actualizar |
| DELETE | /posts/1 | Posts::delete(1) | Eliminar |

**¿Por qué `posts/search` va antes?**
Las rutas se evalúan en orden. Si `resource('posts')` va primero, `posts/search` sería interpretado como `posts/{id}` con `id='search'`.

---

### Paso 6: Implementar la Lógica del Controlador

#### index() - GET /posts
```php
return $this->respond($this->model->findAll());
```
**`findAll()`**: Obtiene todos los registros.
**`respond()`**: Devuelve JSON con código 200.

#### show($id) - GET /posts/{id}
```php
$post = $this->model->find($id);
if ($post === null) {
    return $this->failNotFound('Post no encontrado');
}
return $this->respond($post);
```
Verifica que el post existe antes de devolverlo.

#### create() - POST /posts
- Obtiene datos JSON
- Valida con reglas
- Convierte tags a JSON si es array
- Inserta en BD
- Devuelve código 201

#### update($id) - PUT /posts/{id}
- Valida datos (reglas menos estrictas)
- Verifica que el post existe
- Actualiza
- Devuelve post actualizado

#### delete($id) - DELETE /posts/{id}
- Verifica que el post existe
- Elimina
- Devuelve confirmación

#### search() - GET /posts/search?term={palabra}
```php
$posts = $this->model
    ->like('title', $term)
    ->orLike('content', $term)
    ->orLike('category', $term)
    ->findAll();
```
**`like()` y `orLike()`**: Búsqueda con LIKE SQL.

---

### Paso 7: Validar los Datos

#### ¿Por qué validar en el servidor?
**¡NUNCA confíes en el cliente!**

Razones:
- 🔒 **Seguridad**: El cliente puede ser manipulado
- 🛡️ **Integridad**: Garantizar datos correctos en la BD
- 🚫 **Prevención**: Evitar inyecciones SQL, XSS, etc.

#### Reglas de validación

**En create():**
```php
$rules = [
    'title' => 'required|min_length[5]',
    'content' => 'required|min_length[10]',
    'category' => 'required'
];
```

**En update():**
```php
$rules = [
    'title' => 'permit_empty|min_length[5]',
    'content' => 'permit_empty|min_length[10]',
    'category' => 'permit_empty'
];
```

**Diferencia:**
- `required`: El campo DEBE estar presente
- `permit_empty`: El campo es opcional, pero si está presente debe cumplir las reglas

---

## Endpoints de la API

### Resumen de Endpoints

| Método | Endpoint | Descripción | Código Éxito | Código Error |
|--------|----------|-------------|--------------|--------------|
| GET | /posts | Listar todos los posts | 200 | - |
| GET | /posts/{id} | Obtener un post | 200 | 404 |
| POST | /posts | Crear un post | 201 | 400 |
| PUT | /posts/{id} | Actualizar un post | 200 | 400, 404 |
| DELETE | /posts/{id} | Eliminar un post | 200 | 404 |
| GET | /posts/search?term={palabra} | Buscar posts | 200 | 400 |

### Códigos de Estado HTTP

#### Códigos de Éxito (2xx)
- **200 OK**: Petición exitosa
- **201 Created**: Recurso creado exitosamente

#### Códigos de Error del Cliente (4xx)
- **400 Bad Request**: Datos inválidos
- **404 Not Found**: Recurso no encontrado

---

## Pruebas

### Configuración
1. Descargar Postman: https://www.postman.com/downloads/
2. Servidor corriendo: `php spark serve`
3. URL base: `http://localhost:8080`

### Ejemplos de Pruebas

#### 1. Crear Post (POST /posts)
```json
{
  "title": "Mi Primer Post en CI4",
  "content": "Este es el contenido de mi primer post.",
  "category": "Desarrollo",
  "tags": ["php", "codeigniter", "api"]
}
```

#### 2. Listar Posts (GET /posts)
Devuelve array con todos los posts.

#### 3. Obtener Post (GET /posts/1)
Devuelve un post específico.

#### 4. Actualizar Post (PUT /posts/1)
```json
{
  "title": "Título Actualizado"
}
```

#### 5. Buscar (GET /posts/search?term=ci4)
Busca en title, content y category.

#### 6. Eliminar (DELETE /posts/1)
Elimina el post.

---

## Reflexión Final

### ¿Qué fue lo más fácil?
La **configuración inicial** y la **creación de rutas con `resource()`**. CodeIgniter 4 tiene excelentes herramientas CLI que generan código automáticamente.

### ¿Qué fue lo más difícil?
1. **Configurar SQLite correctamente** con rutas absolutas
2. **Entender ResourceController** vs Controller
3. **Manejo de tags como JSON** en SQLite

### ¿Qué aprendí?

**Sobre CodeIgniter 4:**
- ✅ Framework bien estructurado con separación clara de responsabilidades
- ✅ Sistema de migraciones poderoso
- ✅ Modelos con características de seguridad integradas
- ✅ Spark es increíblemente útil
- ✅ Documentación excelente

**Sobre APIs REST:**
- ✅ Importancia de códigos de estado HTTP correctos
- ✅ Estructura de URLs RESTful
- ✅ Validación del servidor es CRÍTICA
- ✅ Respuestas consistentes facilitan consumo

**Conceptos clave:**
1. **Patrón MVC**: Separación clara de responsabilidades
2. **Mass Assignment Protection**: `$allowedFields` es crucial
3. **Migraciones**: Control de versiones para BD
4. **RESTful Design**: APIs predecibles y fáciles de usar
5. **Validación**: Nunca confiar en el cliente

### Próximos pasos
- 🔐 Autenticación con JWT
- 📄 Paginación
- 🔍 Filtros avanzados
- 📝 Documentación con Swagger
- ✅ Tests automatizados
- 🚀 Rate limiting

---

## Conclusión

Este proyecto fue una excelente introducción a CodeIgniter 4 y al desarrollo de APIs RESTful. La combinación de CI4 con SQLite resultó perfecta para aprendizaje y desarrollo rápido.

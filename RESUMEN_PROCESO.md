# 📊 Resumen del Proceso - Noah Catalán

## 🎯 Objetivo Completado

He conseguido levantar exitosamente el proyecto de API RESTful Blog usando CodeIgniter 4 y SQLite. Este documento resume todo lo que hice.

## 📝 Pasos Realizados

### 1. ✅ Verificación del entorno
- Comprobé que tenía PHP 8.2.12 instalado
- Verifiqué Composer 2.8.12

### 2. ✅ Configuración inicial
- Copié el archivo `env` a `.env`
- Configuré las variables de entorno:
  - `CI_ENVIRONMENT = development`
  - `app.baseURL = 'http://localhost:8080/'`
  - Base de datos SQLite en `writable/database/blog.db`

### 3. ✅ Instalación de dependencias
- Ejecuté `composer install` para instalar CodeIgniter 4 y todas las librerías
- Se instalaron 33 paquetes correctamente

### 4. ✅ Habilitación de SQLite3
- Encontré que la extensión `sqlite3` estaba deshabilitada en PHP
- Edité el archivo `C:\xampp\php\php.ini`
- Descomenté la línea: `extension=sqlite3`
- Verifiqué que se habilitó con `php -m`

### 5. ✅ Ejecución de migraciones
- Ejecuté `php spark migrate`
- Se creó la tabla `posts` con todos sus campos en SQLite

### 6. ✅ Inicio del servidor
- Levanté el servidor con `php spark serve`
- El servidor quedó escuchando en `http://localhost:8080`

### 7. ✅ Pruebas de la API
Probé todos los endpoints principales:
- **GET /posts**: Listar todos los posts → ✅ Funciona
- **POST /posts**: Crear un nuevo post → ✅ Funciona
- **GET /posts/4**: Obtener un post específico → ✅ Funciona
- **GET /posts/search?term=noah**: Buscar posts → ✅ Funciona

## 🔧 Problemas Resueltos

### Problema 1: SQLite3 no habilitado
**Solución**: Editar `php.ini` y descomentar `extension=sqlite3`

### Problema 2: Error UTF-8 en PowerShell
**Solución**: Usar archivos JSON con `-InFile` en lugar de pasar JSON directo en el comando

## 💾 Archivos Creados/Modificados

1. `.env` - Configuración del entorno
2. `README.md` - Documentación actualizada
3. `PRUEBAS_REALIZADAS.md` - Documento de pruebas
4. `RESUMEN_PROCESO.md` - Este archivo
5. `test_post.json` - Archivo de prueba para crear posts

## 📚 Lo que he Aprendido

1. **CodeIgniter 4**: 
   - Cómo funciona el patrón MVC
   - El sistema de rutas
   - Los controladores RESTful
   - Las migraciones de base de datos

2. **APIs RESTful**:
   - Los verbos HTTP (GET, POST, PUT, DELETE)
   - Códigos de estado HTTP (200, 201, 404, 500)
   - Formato JSON para peticiones y respuestas
   - Validación de datos en el backend

3. **SQLite**:
   - Base de datos ligera en un solo archivo
   - No necesita servidor, ideal para desarrollo
   - Compatible con el estándar SQL

4. **Herramientas**:
   - **Composer**: Gestor de dependencias de PHP
   - **Spark**: CLI de CodeIgniter 4
   - **PowerShell**: Para probar la API desde terminal

## 🎓 Reflexión Personal

Este proyecto me ha ayudado a entender cómo funcionan las APIs RESTful por detrás. Antes solo las consumía desde JavaScript, pero ahora entiendo cómo se construyen con PHP.

Lo más difícil fue entender la estructura de CodeIgniter 4 al principio, pero una vez que captas el patrón MVC todo tiene mucho sentido. 

También me di cuenta de la importancia de:
- Leer los logs cuando algo falla
- Verificar la configuración del entorno
- Probar cada endpoint después de implementarlo

## ✅ Estado Final del Proyecto

- ✅ Proyecto funcionando al 100%
- ✅ Todos los endpoints operativos
- ✅ Base de datos creada y funcionando
- ✅ Documentación completa
- ✅ Pruebas realizadas y documentadas

---

**Autor:** Noah Catalán  
**Curso:** 2º DAW - CIFP Francesc de Borja Moll  
**Fecha:** 19 de Noviembre 2025

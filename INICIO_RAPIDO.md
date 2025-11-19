# 🚀 Inicio Rápido - Blog API RESTful

## Para ejecutar este proyecto inmediatamente:

### Paso 1: Clonar y entrar al proyecto
```powershell
cd c:\Users\34666\Desktop\05-blog-como-ejemplo-de-api-restful-noah-catalan
```

### Paso 2: Verificar requisitos
```powershell
php -v        # Debe ser 8.1+
composer -V   # Debe estar instalado
```

### Paso 3: El proyecto ya está configurado ✅

Los siguientes pasos ya están hechos, pero si necesitas replicar el proyecto desde cero:

```powershell
# Copiar configuración (YA HECHO)
Copy-Item env .env

# Instalar dependencias (YA HECHO)
composer install

# Ejecutar migraciones (YA HECHO)
php spark migrate
```

### Paso 4: Iniciar el servidor
```powershell
# Opción 1: En ventana nueva
Start-Process powershell -ArgumentList "-NoExit", "-Command", "php spark serve"

# Opción 2: En la misma ventana (ocupará el terminal)
php spark serve
```

### Paso 5: Probar la API

**Opción A: Con PowerShell**
```powershell
# Ver todos los posts
Invoke-WebRequest -Uri http://localhost:8080/posts | Select-Object -ExpandProperty Content

# Ver un post específico
Invoke-WebRequest -Uri http://localhost:8080/posts/1 | Select-Object -ExpandProperty Content

# Buscar posts
Invoke-WebRequest -Uri "http://localhost:8080/posts/search?term=post" | Select-Object -ExpandProperty Content
```

**Opción B: Con el navegador**
```
http://localhost:8080/posts
http://localhost:8080/posts/1
http://localhost:8080/posts/search?term=post
```

**Opción C: Con el script de pruebas**
```powershell
Set-ExecutionPolicy -Scope Process -ExecutionPolicy Bypass
.\test_api.ps1
```

---

## 📋 Endpoints Disponibles

| Método | URL | Descripción |
|--------|-----|-------------|
| GET | `http://localhost:8080/posts` | Listar todos |
| GET | `http://localhost:8080/posts/1` | Ver post 1 |
| POST | `http://localhost:8080/posts` | Crear post |
| PUT | `http://localhost:8080/posts/1` | Actualizar post 1 |
| DELETE | `http://localhost:8080/posts/1` | Eliminar post 1 |
| GET | `http://localhost:8080/posts/search?term=palabra` | Buscar |

---

## 🆘 Problemas Comunes

### Error: "sqlite3 extension not loaded"
**Solución:**
1. Abre `C:\xampp\php\php.ini`
2. Busca `;extension=sqlite3`
3. Quita el `;` para descomentar
4. Reinicia el terminal

### Error: "port 8080 already in use"
**Solución:**
```powershell
# Usar otro puerto
php spark serve --port=8081
```

### Error: Script execution disabled
**Solución:**
```powershell
Set-ExecutionPolicy -Scope Process -ExecutionPolicy Bypass
```

---

## 📚 Documentación Completa

- **[README.md](README.md)** - Documentación principal
- **[RESUMEN_PROCESO.md](RESUMEN_PROCESO.md)** - Cómo se hizo todo
- **[PRUEBAS_REALIZADAS.md](PRUEBAS_REALIZADAS.md)** - Pruebas con capturas

---

**Autor:** Noah Catalán | **Fecha:** Nov 2025

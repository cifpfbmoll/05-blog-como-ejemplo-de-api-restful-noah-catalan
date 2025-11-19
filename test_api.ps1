# Script de Pruebas Rápidas de la API
# Autor: Noah Catalán
# Fecha: 19/11/2025

Write-Host "========================================" -ForegroundColor Green
Write-Host "  PRUEBAS API BLOG - NOAH CATALAN" -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Green
Write-Host ""

# Verificar que el servidor está corriendo
Write-Host "[1/4] Verificando servidor..." -ForegroundColor Cyan
try {
    $response = Invoke-WebRequest -Uri "http://localhost:8080" -Method GET -TimeoutSec 5
    Write-Host "✅ Servidor funcionando correctamente" -ForegroundColor Green
} catch {
    Write-Host "❌ Error: El servidor no está corriendo" -ForegroundColor Red
    Write-Host "Ejecuta: php spark serve" -ForegroundColor Yellow
    exit
}

Write-Host ""

# Prueba 1: GET /posts
Write-Host "[2/4] GET /posts - Listando todos los posts..." -ForegroundColor Cyan
try {
    $response = Invoke-WebRequest -Uri "http://localhost:8080/posts" -Method GET
    $posts = $response.Content | ConvertFrom-Json
    Write-Host "✅ Estado: $($response.StatusCode) $($response.StatusDescription)" -ForegroundColor Green
    Write-Host "   Total de posts: $($posts.Count)" -ForegroundColor White
} catch {
    Write-Host "❌ Error en GET /posts" -ForegroundColor Red
}

Write-Host ""

# Prueba 2: GET /posts/1
Write-Host "[3/4] GET /posts/1 - Obteniendo post específico..." -ForegroundColor Cyan
try {
    $response = Invoke-WebRequest -Uri "http://localhost:8080/posts/1" -Method GET
    $post = $response.Content | ConvertFrom-Json
    Write-Host "✅ Estado: $($response.StatusCode) $($response.StatusDescription)" -ForegroundColor Green
    Write-Host "   Título: $($post.title)" -ForegroundColor White
} catch {
    Write-Host "❌ Error en GET /posts/1" -ForegroundColor Red
}

Write-Host ""

# Prueba 3: Búsqueda
Write-Host "[4/4] GET /posts/search?term=post - Buscando posts..." -ForegroundColor Cyan
try {
    $response = Invoke-WebRequest -Uri "http://localhost:8080/posts/search?term=post" -Method GET
    $results = $response.Content | ConvertFrom-Json
    Write-Host "✅ Estado: $($response.StatusCode) $($response.StatusDescription)" -ForegroundColor Green
    Write-Host "   Resultados encontrados: $($results.Count)" -ForegroundColor White
} catch {
    Write-Host "❌ Error en búsqueda" -ForegroundColor Red
}

Write-Host ""
Write-Host "========================================" -ForegroundColor Green
Write-Host "  PRUEBAS COMPLETADAS" -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Green
Write-Host ""
Write-Host "💡 Para más pruebas, consulta PRUEBAS_REALIZADAS.md" -ForegroundColor Yellow

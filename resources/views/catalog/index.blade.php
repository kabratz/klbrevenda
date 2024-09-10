<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Catálogo de Produtos</title>
    <!-- Incluindo o CSS compilado pelo Vite -->
    @vite('resources/css/app.css')
</head>
<body>
    <div id="app">
        <!-- O componente Vue Catalog será montado aqui -->
        <catalog></catalogt>
    </div>

    <!-- Incluindo o JS compilado pelo Vite -->
    @vite('resources/js/app.js')
</body>
</html>

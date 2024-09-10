<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KLB Revenda</title>
    @vite(['resources/css/app.css', 'resources/js/app.js']) <!-- Usa Vite -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>
    <div id="app"></div> <!-- Onde o Vue será montado -->
</body>
</html>
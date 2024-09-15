<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KLB Revenda</title>
    @vite(['resources/css/app.css', 'resources/js/app.js']) <!-- Usa Vite -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <html lang=”pt-br”>

</head>

<body>
    <div id="app">
    </div> <!-- Onde o Vue será montado -->
</body>


<footer>
    <div class="links">
        <a href="/login">Acessar Login Admin</a>
        <a href="/">Acessar Catálogo</a>
    </div>
    <p>© 2024 - Todos os direitos reservados</p>

    <a href="https://www.linkedin.com/in/karoline-luersen-bratz/" class="developer-info" target="_blank">
        <img src="/creator.jpeg" alt="Foto de Karoline Luersen Bratz, desenvolvedora do Site" />
        <p>Desenvolvido por Karoline Luersen Bratz</p>
    </a>
</footer>

</html>
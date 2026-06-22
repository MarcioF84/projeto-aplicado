<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MF</title>
    <link rel="stylesheet" href="assets/css/site.css">
</head>

<body>

    <div id="overlay" class="overlay" onclick="toggleMenu()"></div>

    <nav id="sidebar">
        <div class="nav-header">Meu App</div>
        <ul>
            <li><button onclick="navigate('home')"><i data-lucide="home"></i> Início</button></li>
            <!-- <li><button onclick="navigate('usuario-list')"><i data-lucide="table"></i> Usuários</button></li> -->
            <!-- <li><button onclick="navigate('tipo-usuario-list')"><i data-lucide="table"></i> Tipo de Usuário</button></li> -->
            <!-- <li><button onclick="navigate('marca-list')"><i data-lucide="table"></i> Marcas</button></li> -->
            <!-- <li><button onclick="navigate('modelo-list')"><i data-lucide="table"></i> Modelo</button></li> -->
        </ul>
    </nav>

    <main>
        <header>
            <button class="menu-toggle" onclick="toggleMenu()">☰</button>
            <h1 id="page-title">Início</h1>
        </header>

        <section class="content">
            <!-- Página Home -->
            <div id="home" class="card page"></div>

            <!-- Página Usuários -->
            <div id="usuario-list" class="table-container page hidden"></div>
            <div id="usuario-add" class="card page hidden"></div>            
            <div id="usuario-alt" class="card page hidden"></div>
            
            <!-- Página Tipo de Usuários -->
            <div id="tipo-usuario-list" class="table-container page hidden"></div>
            <div id="tipo-usuario-add" class="card page hidden"></div>
            <div id="tipo-usuario-alt" class="card page hidden"></div>

            <!-- Página Marcas -->
            <div id="marca-list" class="table-container page hidden"></div>
            <div id="marca-add" class="card page hidden"></div>
            <div id="marca-alt" class="card page hidden"></div>

            <!-- Página Modelo -->
            <div id="modelo-list" class="table-container page hidden"></div>
            <div id="modelo-add" class="card page hidden"></div>
            <div id="modelo-alt" class="card page hidden"></div>

            <!-- Página Carona -->
            <div id="carona-list" class="table-container page hidden"></div>
            <div id="carona-search" class="table-container page hidden"></div>
            <div id="carona-reservada" class="table-container page hidden"></div>
            <div id="carona-add" class="card page hidden"></div>
            <div id="carona-alt" class="card page hidden"></div>
            <div id="carona-detail" class="card page hidden"></div>
            <div id="carona-reserva-confirma" class="card page hidden"></div>
            


            <div id="modal" class="modal hidden">
                <div class="modal-content">
                    <p id="modal-message">Salvando...</p>
                </div>
            </div>
        </section>
    </main>
    <script src="assets/js/lucide.min.js"></script>
    <script src="assets/js/site.js" defer></script>
    <script>
        window.onload = function() {
            navigate('home');
            lucide.createIcons();
        };
    </script>
</body>

</html>
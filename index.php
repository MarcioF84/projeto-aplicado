<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MF</title>
    <link rel="stylesheet" href="assets/css/site.css">
</head>

<body>
    <main>            

        <section class="content">
            
            <!-- Página Login -->
            <div id="login" class="card page"></div>

            <!-- Página Usuários -->
            <div id="usuario-add" class="card page hidden"></div>
            <div id="usuario-doc-add" class="card page hidden"></div>
            <div id="usuario-add-conclui" class="card page hidden"></div>

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
            navigate('login');
            lucide.createIcons();
        };
    </script>
</body>

</html>
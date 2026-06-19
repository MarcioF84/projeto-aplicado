<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MF</title>
    <link rel="stylesheet" href="inc/site.css">
</head>

<body>

    <main>

        <section class="content">
            <!-- Página Login -->
            <div id="page-form-login" class="card page"></div>

            <!-- Formulário Novo Cadastro -->
            <div id="page-form-add-user" class="card page hidden"></div>

            <!-- Formulário Atualizar Cadastro -->
            <div id="page-form-alt-user" class="card page hidden"></div>

            <div id="modal" class="modal hidden">
                <div class="modal-content">
                    <p id="modal-message">Salvando...</p>
                </div>
            </div>
        </section>
    </main>
    <script src="inc/lucide.min.js"></script>
    <script src="inc/site.js" defer></script>
    <script>
        window.onload = function () {
            loadPage('page-form-login', 'form_login.php');
            lucide.createIcons();
        };
    </script>
</body>

</html>
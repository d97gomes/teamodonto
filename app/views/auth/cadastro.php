<?php
// Página pública
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Criar Conta - TeamOdonto</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">

        <div class="col-11 col-sm-8 col-md-5 col-lg-4">

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">

                    <!-- TÍTULO -->
                    <h4 class="text-center fw-bold mb-1">TeamOdonto</h4>
                    <p class="text-center text-muted mb-4">
                        Criar nova conta
                    </p>

                    <form method="post" action="api.php?api=usuario-publico">

                        <!-- NOME -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nome</label>
                            <input type="text" name="nome" class="form-control" placeholder="Digite seu nome" required>
                        </div>

                        <!-- EMAIL -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">E-mail</label>
                            <input type="email" name="email" class="form-control" placeholder="Digite seu email" required>
                        </div>

                        <!-- SENHA -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Senha</label>
                            <input type="password" name="senha" class="form-control" placeholder="Digite sua senha" required>
                        </div>

                        <!-- BOTÃO -->
                        <button type="submit" class="btn btn-success w-100 fw-semibold">
                            Criar Conta
                        </button>

                    </form>

                    <!-- LINK VOLTAR -->
                    <div class="text-center mt-3">
                        <span class="small text-muted">Já possui conta?</span><br>
                        <a href="index.php?page=login" class="fw-semibold text-decoration-none">
                            Voltar para login
                        </a>
                    </div>

                </div>
            </div>

            <!-- RODAPÉ -->
            <p class="text-center text-muted small mt-3">
                © TeamOdonto
            </p>

        </div>

    </div>
</div>

</body>
</html>
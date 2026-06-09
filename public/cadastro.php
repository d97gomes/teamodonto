<?php
// PÁGINA PÚBLICA — NÃO PASSA POR SESSÃO
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Criar Conta - TeamOdonto</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="card shadow-sm p-4">
                <h4 class="fw-bold mb-3 text-center">Criar Conta</h4>

                <form method="post" action="api.php?api=usuario-publico">

                    <div class="mb-3">
                        <label class="form-label">Nome</label>
                        <input type="text" name="nome" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">E-mail</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Senha</label>
                        <input type="password" name="senha" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-success w-100 fw-bold">
                        Criar Conta
                    </button>
                </form>

                <div class="text-center mt-3">
                    <a href="index.php?page=login">Já tenho conta</a>
                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>
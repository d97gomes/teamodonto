<?php
$token = $_GET['token'] ?? null;

if (!$token) {
    echo "<h4 class='text-center mt-5'>Token inválido ❌</h4>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Redefinir Senha - TeamOdonto</title>
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

                    <h4 class="text-center fw-bold mb-1">TeamOdonto</h4>
                    <p class="text-center text-muted mb-4">
                        Redefinir senha
                    </p>

                    <div id="mensagem" class="alert d-none"></div>

                    <form id="formReset">

                        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nova senha</label>
                            <input type="password" name="senha" class="form-control" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Confirmar senha</label>
                            <input type="password" name="confirmar" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-success w-100">
                            Atualizar senha
                        </button>

                    </form>

                    <div class="text-center mt-3">
                        <a href="index.php?page=login">Voltar ao login</a>
                    </div>

                </div>
            </div>

            <p class="text-center text-muted small mt-3">
                © TeamOdonto
            </p>

        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
document.getElementById('formReset').addEventListener('submit', e => {
    e.preventDefault();

    const dados = Object.fromEntries(new FormData(e.target));

    const msg = document.getElementById('mensagem');

    if (dados.senha !== dados.confirmar) {
        msg.className = 'alert alert-danger';
        msg.classList.remove('d-none');
        msg.innerHTML = 'As senhas não coincidem ❌';
        return;
    }

    axios.post('/teamOdonto/public/api.php?api=redefinir-senha', dados)
    .then(res => {

        if (res.data.success) {

            msg.className = 'alert alert-success';
            msg.classList.remove('d-none');
            msg.innerHTML = 'Senha atualizada com sucesso ✅';

            setTimeout(() => {
                window.location.href = '/teamOdonto/public/index.php?page=login';
            }, 1500);

        } else {
            msg.className = 'alert alert-danger';
            msg.classList.remove('d-none');
            msg.innerHTML = 'Erro ao atualizar senha ❌';
        }

    })
    .catch(() => {
        msg.className = 'alert alert-danger';
        msg.classList.remove('d-none');
        msg.innerHTML = 'Erro no servidor ❌';
    });

});
</script>

</body>
</html>
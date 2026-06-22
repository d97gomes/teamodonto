<?php
// Página pública
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Senha - TeamOdonto</title>
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
                        Recuperar senha
                    </p>

                    <!-- ALERTA -->
                    <div id="mensagem" class="alert d-none"></div>

                    <form id="formRecuperar">

                        <!-- EMAIL -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">E-mail</label>
                            <input 
                                type="email" 
                                name="email" 
                                class="form-control"
                                placeholder="Digite seu email"
                                required
                            >
                        </div>

                        <!-- BOTÃO -->
                        <button type="submit" class="btn btn-primary w-100 fw-semibold">
                            Enviar recuperação
                        </button>

                    </form>

                    <!-- VOLTAR -->
                    <div class="text-center mt-3">
                        <a href="index.php?page=login" class="text-decoration-none fw-semibold">
                            Voltar ao login
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

<!-- Axios -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<!-- JS -->
<script>
document.addEventListener('DOMContentLoaded', () => {

    const form = document.getElementById('formRecuperar');
    const msg = document.getElementById('mensagem');

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const dados = Object.fromEntries(new FormData(form));

        axios.post('/teamOdonto/public/api.php?api=recuperar-senha', dados)
        .then(res => {

            msg.className = 'alert alert-success';
            msg.classList.remove('d-none');

            msg.innerHTML = 'Se o email existir, você receberá instruções ✅';

        })
        .catch(() => {

            msg.className = 'alert alert-danger';
            msg.classList.remove('d-none');

            msg.innerHTML = 'Erro ao enviar recuperação ❌';

        });

    });

});
</script>

</body>
</html>

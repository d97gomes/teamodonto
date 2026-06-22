<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login | TeamOdonto</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" 
        rel="stylesheet"
    >
</head>

<body class="bg-light">

<div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">

        <div class="col-11 col-sm-8 col-md-5 col-lg-4">

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">

                    <h4 class="text-center fw-bold mb-1">TeamOdonto</h4>
                    <p class="text-center text-muted mb-4">
                        Acesso ao sistema
                    </p>

                    <!-- Mensagens -->
                    <div id="mensagem" class="alert d-none"></div>

                                <form id="formLogin" novalidate>

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Email
                    </label>
                    <input 
                        type="email" 
                        name="email" 
                        class="form-control"
                        placeholder="Digite seu email"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Senha
                    </label>
                    <input 
                        type="password" 
                        name="senha" 
                        class="form-control"
                        placeholder="Digite sua senha"
                        required
                    >
                </div>

                <!-- ✅ LINK RECUPERAR SENHA -->
                <div class="text-end mb-3">
                    <a href="/teamOdonto/public/index.php?page=recuperar-senha"
                    class="small text-decoration-none">
                        Esqueci minha senha
                    </a>
                </div>

                <button 
                    type="submit" 
                    class="btn btn-primary w-100 fw-semibold"
                >
                    Entrar
                </button>

                <!-- ✅ LINK CRIAR USUÁRIO -->
                <div class="text-center mt-3">
                    <span class="small text-muted">Não tem conta?</span>
                    <a href="/teamOdonto/public/index.php?page=usuario-create"
                    class="text-decoration-none fw-semibold">
                        Criar usuário
                    </a>
                </div>

            </form>

                </div>
            </div>

            <p class="text-center text-muted small mt-3">
                © TeamOdonto
            </p>

        </div>

    </div>
</div>

<!-- Axios -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<!-- JS do login -->
<script src="/teamOdonto/public/js/login.js"></script>

</body>
</html>
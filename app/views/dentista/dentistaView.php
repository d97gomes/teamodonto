<?php
if (!defined('APP_ROUTER')) {
    header('Location: /teamOdonto/public/index.php?page=login');
    exit;
}

$title = 'Dentista';

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/sidebar.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: /teamOdonto/public/index.php?page=dentista-list');
    exit;
}
?>

<main class="main-content" data-dentista="<?= (int)$id ?>">

    <div class="container-fluid px-3 px-md-4 px-lg-5 pt-4">

        <!-- ✅ HEADER PADRÃO -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">

            <h4 class="fw-bold mb-0">
                Dentista: <span id="dentista-nome-titulo"></span>
            </h4>

            <a href="/teamOdonto/public/index.php?page=dentista-list"
               class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i>
                Voltar
            </a>

        </div>

        <!-- ✅ CARD PRINCIPAL -->
        <div class="card border-0 shadow-sm p-3 p-md-4">

            <!-- ABAS -->
            <ul class="nav nav-tabs mb-4">
                <li class="nav-item">
                    <button class="nav-link active"
                            data-bs-toggle="tab"
                            data-bs-target="#dados">
                        Dados do Dentista
                    </button>
                </li>
            </ul>

            <div class="tab-content">

                <div class="tab-pane fade show active" id="dados">

                    <div class="row g-3">

                        <!-- DADOS PESSOAIS -->
                        <div class="col-12 col-md-6">
                            <div class="card h-100">
                                <div class="card-header fw-bold">
                                    Dados Pessoais
                                </div>

                                <div class="card-body small">
                                    <p><strong>Nome:</strong> <span id="dentista-nome"></span></p>
                                    <p><strong>CPF:</strong> <span id="dentista-cpf"></span></p>
                                    <p><strong>Telefone:</strong> <span id="dentista-telefone"></span></p>
                                    <p><strong>Email:</strong> <span id="dentista-email"></span></p>
                                </div>
                            </div>
                        </div>

                        <!-- DADOS PROFISSIONAIS -->
                        <div class="col-12 col-md-6">
                            <div class="card h-100">
                                <div class="card-header fw-bold">
                                    Dados Profissionais
                                </div>

                                <div class="card-body small">
                                    <p><strong>Sexo:</strong> <span id="dentista-sexo"></span></p>
                                    <p><strong>CRO:</strong> <span id="dentista-cro"></span></p>
                                    <p><strong>Especialidade:</strong> <span id="dentista-especialidade"></span></p>
                                </div>
                            </div>
                        </div>

                        <!-- ENDEREÇO -->
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header fw-bold">
                                    Endereço
                                </div>

                                <div class="card-body small">

                                    <p>
                                        <span id="endereco-logradouro"></span>,
                                        <span id="endereco-numero"></span>
                                    </p>

                                    <p>
                                        <span id="endereco-bairro"></span> –
                                        <span id="endereco-cidade"></span> /
                                        <span id="endereco-estado"></span>
                                    </p>

                                    <p>
                                        <strong>CEP:</strong>
                                        <span id="endereco-cep"></span>
                                    </p>

                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</main>

<script src="/teamOdonto/public/js/anamnese/anamnese-dentista.js"></script>
<script src="/teamOdonto/public/js/dentista/dentista-view.js"></script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
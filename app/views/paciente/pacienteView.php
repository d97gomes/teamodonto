<?php
$title = 'Paciente';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
require_once __DIR__ . '/../includes/sidebar.php';
?>

<div class="container-fluid py-4">

    <!-- TÍTULO DO PERFIL -->
    <h4 class="mb-3">
        Paciente: <span id="paciente-nome-titulo"></span>
    </h4>

    <!-- MENU DE RELAÇÕES (ABAS) -->
    <ul class="nav nav-tabs mb-3" id="pacienteTabs" role="tablist">
        <li class="nav-item">
            <button class="nav-link active"
                    data-bs-toggle="tab"
                    data-bs-target="#dados"
                    type="button">
                Dados do Paciente
            </button>
        </li>

        <li class="nav-item">
            <button class="nav-link"
                    data-bs-toggle="tab"
                    data-bs-target="#anamnese"
                    type="button">
                Anamnese
            </button>
        </li>

        <li class="nav-item">
            <button class="nav-link"
                    data-bs-toggle="tab"
                    data-bs-target="#orcamentos"
                    type="button">
                Orçamentos
            </button>
        </li>

        <li class="nav-item">
            <button class="nav-link"
                    data-bs-toggle="tab"
                    data-bs-target="#agendamentos"
                    type="button">
                Agendamentos
            </button>
        </li>

        <li class="nav-item">
            <button class="nav-link"
                    data-bs-toggle="tab"
                    data-bs-target="#consultas"
                    type="button">
                Consultas
            </button>
        </li>
    </ul>

    <!-- CONTEÚDO DAS ABAS -->
    <div class="tab-content border border-top-0 p-3">

        <!-- ABA: DADOS DO PACIENTE -->
        <div class="tab-pane fade show active" id="dados" role="tabpanel">

            <!-- DADOS PESSOAIS -->
            <div class="card mb-3">
                <div class="card-header fw-bold">
                    Dados Pessoais
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Nome:</strong> <span id="paciente-nome"></span></p>
                            <p><strong>CPF:</strong> <span id="paciente-cpf"></span></p>
                            <p><strong>Telefone:</strong> <span id="paciente-telefone"></span></p>
                            <p><strong>Email:</strong> <span id="paciente-email"></span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Data de Nascimento:</strong>
                                <span id="paciente-data-nascimento"></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ENDEREÇO -->
            <div class="card">
                <div class="card-header fw-bold">
                    Endereço
                </div>
                <div class="card-body">
                    <p>
                        <span id="endereco-logradouro"></span>,
                        <span id="endereco-numero"></span>
                    </p>
                    <p>
                        <span id="endereco-bairro"></span> –
                        <span id="endereco-cidade"></span>/<span id="endereco-estado"></span>
                    </p>
                    <p><strong>CEP:</strong> <span id="endereco-cep"></span></p>
                </div>
            </div>

        </div>

        <!-- ABA: ANAMNESE -->
        <div class="tab-pane fade" id="anamnese" role="tabpanel">
            <p class="text-muted">Nenhuma anamnese registrada.</p>
            <button class="btn btn-sm btn-primary">
                Nova Anamnese
            </button>
        </div>

        <!-- ABA: ORÇAMENTOS -->
        <div class="tab-pane fade" id="orcamentos" role="tabpanel">
            <p class="text-muted">Nenhum orçamento encontrado.</p>
            <button class="btn btn-sm btn-primary">
                Novo Orçamento
            </button>
        </div>

        <!-- ABA: AGENDAMENTOS -->
        <div class="tab-pane fade" id="agendamentos" role="tabpanel">
            <p class="text-muted">Nenhum agendamento futuro.</p>
            <button class="btn btn-sm btn-primary">
                Novo Agendamento
            </button>
        </div>

        <!-- ABA: CONSULTAS -->
        <div class="tab-pane fade" id="consultas" role="tabpanel">
            <p class="text-muted">Nenhuma consulta registrada.</p>
        </div>

    </div>

</div>

<!-- SCRIPT EXCLUSIVO DA VIEW -->
<script src="/teamOdonto/public/js/paciente/paciente-view.js"></script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
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

    <nav class="navbar navbar-custom sticky-top">
        <h5 class="mb-0 fw-bold">
            Dentista: <span id="dentista-nome-titulo"></span>
        </h5>
    </nav>

    <div class="p-4 p-lg-5">

        <div class="card border-0 shadow-sm">

            <!-- ABAS -->
            <ul class="nav nav-tabs px-3 pt-3" role="tablist">

                <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#dados">
                        Dados do Dentista
                    </button>
                </li>

                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#anamnese">
                        Anamneses
                    </button>
                </li>

                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#agenda">
                        Agenda
                    </button>
                </li>

                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#consultas">
                        Consultas
                    </button>
                </li>

                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#orcamentos">
                        Orçamentos
                    </button>
                </li>

            </ul>

            <!-- CONTEÚDO DAS ABAS -->
            <div class="tab-content p-4">

                <!-- DADOS DO DENTISTA -->
                <div class="tab-pane fade show active" id="dados">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-header fw-bold">Dados Pessoais</div>
                                <div class="card-body">
                                    <p><strong>Nome:</strong> <span id="dentista-nome"></span></p>
                                    <p><strong>CPF:</strong> <span id="dentista-cpf"></span></p>
                                    <p><strong>Telefone:</strong> <span id="dentista-telefone"></span></p>
                                    <p><strong>Email:</strong> <span id="dentista-email"></span></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-header fw-bold">Dados Profissionais</div>
                                <div class="card-body">
                                    <p><strong>Sexo:</strong> <span id="dentista-sexo"></span></p>
                                    <p><strong>CRO:</strong> <span id="dentista-cro"></span></p>
                                    <p><strong>Especialidade:</strong> <span id="dentista-especialidade"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header fw-bold">Endereço</div>
                        <div class="card-body">
                            <p>
                                <span id="endereco-logradouro"></span>,
                                <span id="endereco-numero"></span>
                            </p>
                            <p>
                                <span id="endereco-bairro"></span> –
                                <span id="endereco-cidade"></span> /
                                <span id="endereco-estado"></span>
                            </p>
                            <p><strong>CEP:</strong> <span id="endereco-cep"></span></p>
                        </div>
                    </div>

                </div>

                <!-- ANAMNESES -->
                <div class="tab-pane fade" id="anamnese">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0 fw-bold">Anamneses do Dentista</h6>

                        <a href="/teamOdonto/public/index.php?page=anamnese-create&dentista_id=<?= (int)$id ?>"
                           class="btn btn-sm btn-primary">
                            Nova Anamnese
                        </a>
                    </div>

                    <table class="table table-sm table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Data</th>
                                <th>Paciente</th>
                                <th class="text-end">Ações</th>
                            </tr>
                        </thead>

                        <tbody id="listaAnamnesesDentista">
                            <tr>
                                <td colspan="3" class="text-center text-muted">
                                    Carregando...
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>

                <!-- AGENDA -->
                <div class="tab-pane fade" id="agenda">
                    <p class="text-muted">Nenhum horário cadastrado na agenda.</p>
                    <button class="btn btn-sm btn-primary">Novo Horário</button>
                </div>

                <!-- CONSULTAS -->
                <div class="tab-pane fade" id="consultas">
                    <p class="text-muted">Nenhuma consulta registrada.</p>
                </div>

                <!-- ORÇAMENTOS -->
                <div class="tab-pane fade" id="orcamentos">
                    <p class="text-muted">Nenhum orçamento vinculado.</p>
                </div>

            </div>

        </div>
    </div>

</main>

<script src="/teamOdonto/public/js/anamnese/anamnese-dentista.js"></script>
<script src="/teamOdonto/public/js/dentista/dentista-view.js"></script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
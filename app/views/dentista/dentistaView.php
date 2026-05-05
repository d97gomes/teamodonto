<?php
if (!defined('APP_ROUTER')) {
    header('Location: /teamOdonto/public/index.php?page=login');
    exit;
}

$title = 'Dentista';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
require_once __DIR__ . '/../includes/sidebar.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: /teamOdonto/public/index.php?page=dentista-list');
    exit;
}
?>

<body data-dentista="<?= (int)$id ?>">

<div class="container-fluid py-4">

    <!-- TÍTULO -->
    <h4 class="mb-3">
        Dentista: <span id="dentista-nome-titulo"></span>
    </h4>

    <!-- ABAS -->
    <ul class="nav nav-tabs mb-3" role="tablist">

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
    <div class="tab-content border border-top-0 p-3">

        <!-- DADOS DO DENTISTA -->
        <div class="tab-pane fade show active" id="dados">

            <div class="card mb-3">
                <div class="card-header fw-bold">Dados Pessoais</div>
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-6">
                            <p><strong>Nome:</strong> <span id="dentista-nome"></span></p>
                            <p><strong>CPF:</strong> <span id="dentista-cpf"></span></p>
                            <p><strong>Telefone:</strong> <span id="dentista-telefone"></span></p>
                            <p><strong>Email:</strong> <span id="dentista-email"></span></p>
                        </div>

                        <div class="col-md-6">
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
                        <span id="endereco-cidade"></span>/<span id="endereco-estado"></span>
                    </p>
                    <p><strong>CEP:</strong> <span id="endereco-cep"></span></p>
                </div>
            </div>

        </div>

        <!-- ✅ ABA ANAMNESES (AJUSTADA) -->
        <div class="tab-pane fade" id="anamnese">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0">Anamneses do Dentista</h6>

                <a href="/teamOdonto/public/index.php?page=anamnese-create&dentista_id=<?= (int)$id ?>"
                   class="btn btn-sm btn-primary">
                    Nova Anamnese
                </a>
            </div>

            <table class="table table-sm table-bordered">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Paciente</th>
                        <th class="text-center">Ações</th>
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

<!-- JS DA ABA ANAMNESES DO DENTISTA -->
<script src="/teamOdonto/public/js/anamnese/anamnese-dentista.js"></script>

<!-- JS DA VIEW DO DENTISTA -->
<script src="/teamOdonto/public/js/dentista/dentista-view.js"></script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>

<?php
if (!defined('APP_ROUTER')) {
    header('Location: /teamOdonto/public/index.php?page=login');
    exit;
}

if (!isset($_SESSION['usuario'])) {
    header('Location: /teamOdonto/public/index.php?page=login');
    exit;
}

$title = 'Dashboard';

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
require_once __DIR__ . '/../includes/sidebar.php';
?>

<main class="main-content">



    <div class="container-fluid px-3 px-md-4 px-lg-5 pt-5 pt-md-4"

        <!-- BOAS-VINDAS -->
        <div class="mb-4 mb-md-5">
            <h2 class="fw-bold text-dark">
                Olá, <?= $_SESSION['usuario']['nome']; ?> 👋
            </h2>
            <p class="text-secondary mb-0">
                Aqui está um resumo geral do sistema.
            </p>
        </div>

        <!-- ✅ CARDS RESPONSIVOS -->
        <div class="row g-3 g-md-4 mb-4 mb-md-5">

            <!-- PACIENTES -->
            <div class="col-6 col-sm-6 col-md-4 col-lg-3 col-xl-2">
                <div class="card stats-card h-100 p-3 text-center">
                    <div class="stats-icon mx-auto mb-2 bg-primary text-white">
                        <i class="bi bi-people-fill fs-4"></i>
                    </div>
                    <small class="text-uppercase fw-bold text-secondary">Pacientes</small>
                    <h3 id="totalPacientes" class="fw-bold mb-0">--</h3>
                    <span class="text-muted small">Cadastrados</span>
                </div>
            </div>

            <!-- DENTISTAS -->
            <div class="col-6 col-sm-6 col-md-4 col-lg-3 col-xl-2">
                <div class="card stats-card h-100 p-3 text-center">
                    <div class="stats-icon mx-auto mb-2 bg-success text-white">
                        <i class="bi bi-person-badge-fill fs-4"></i>
                    </div>
                    <small class="text-uppercase fw-bold text-secondary">Dentistas</small>
                    <h3 id="totalDentistas" class="fw-bold mb-0">--</h3>
                    <span class="text-muted small">Ativos</span>
                </div>
            </div>

            <!-- ANAMNESES -->
            <div class="col-6 col-sm-6 col-md-4 col-lg-3 col-xl-2">
                <div class="card stats-card h-100 p-3 text-center">
                    <div class="stats-icon mx-auto mb-2 bg-warning text-white">
                        <i class="bi bi-clipboard-heart fs-4"></i>
                    </div>
                    <small class="text-uppercase fw-bold text-secondary">Anamneses</small>
                    <h3 id="totalAnamneses" class="fw-bold mb-0">--</h3>
                    <span class="text-muted small">Registradas</span>
                </div>
            </div>

            <!-- ORÇAMENTOS -->
            <div class="col-6 col-sm-6 col-md-4 col-lg-3 col-xl-2">
                <div class="card stats-card h-100 p-3 text-center">
                    <div class="stats-icon mx-auto mb-2 bg-danger text-white">
                        <i class="bi bi-cash-stack fs-4"></i>
                    </div>
                    <small class="text-uppercase fw-bold text-secondary">Orçamentos</small>
                    <h3 id="totalOrcamentos" class="fw-bold mb-0">--</h3>
                    <span class="text-muted small">Criados</span>
                </div>
            </div>

            <!-- AGENDA -->
            <div class="col-6 col-sm-6 col-md-4 col-lg-3 col-xl-2">
                <div class="card stats-card h-100 p-3 text-center">
                    <div class="stats-icon mx-auto mb-2 bg-info text-white">
                        <i class="bi bi-calendar-check fs-4"></i>
                    </div>
                    <small class="text-uppercase fw-bold text-secondary">Agenda</small>
                    <h3 id="totalAgenda" class="fw-bold mb-0">--</h3>
                    <span class="text-muted small">Agendamentos</span>
                </div>
            </div>

        </div>

        <!-- ✅ TABELA RESPONSIVA -->
        <div class="card p-3 p-md-4 mb-4">
            <h5 class="fw-bold mb-3">Próximos atendimentos</h5>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Paciente</th>
                            <th>Dentista</th>
                            <th>Data</th>
                            <th>Hora</th>
                        </tr>
                    </thead>

                    <tbody id="listaAgendaDashboard">
                        <tr>
                            <td colspan="4" class="text-center text-muted py-3">
                                Carregando...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ACESSO RÁPIDO -->
        <div class="card p-3 p-md-4 mb-5">
            <h5 class="fw-bold mb-2">Acesso rápido</h5>
            <p class="text-secondary mb-0">
                Utilize o menu lateral para acessar pacientes, dentistas,
                anamneses, procedimentos, agenda e orçamentos.
            </p>
        </div>

    </div>

</main>

<!-- ✅ JS (CONTADORES + AGENDA) -->
<script>
document.addEventListener('DOMContentLoaded', () => {

    function carregarTotal(api, id) {
        axios.get(`/teamOdonto/public/api.php?api=${api}`)
            .then(res => {
                document.getElementById(id).textContent = res.data.length || 0;
            });
    }

    carregarTotal('pacientes', 'totalPacientes');
    carregarTotal('dentistas', 'totalDentistas');
    carregarTotal('anamneses', 'totalAnamneses');
    carregarTotal('orcamentos', 'totalOrcamentos');
    carregarTotal('agenda', 'totalAgenda');

    axios.get('/teamOdonto/public/api.php?api=agenda')
        .then(res => {

            const dados = res.data;
            const tbody = document.getElementById('listaAgendaDashboard');

            tbody.innerHTML = '';

            if (!dados.length) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="4" class="text-center text-muted">
                            Nenhum agendamento
                        </td>
                    </tr>
                `;
                return;
            }

            dados.slice(0, 5).forEach(a => {

                tbody.innerHTML += `
                    <tr>
                        <td>${a.paciente}</td>
                        <td>${a.dentista}</td>
                        <td>${new Date(a.data_agenda).toLocaleDateString('pt-BR')}</td>
                        <td>${a.hora_agenda}</td>
                    </tr>
                `;
            });

        });

});
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
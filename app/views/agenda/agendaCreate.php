<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/sidebar.php';
?>

<main class="main-content">
    <nav class="navbar navbar-custom sticky-top">
        <h5 class="mb-0 fw-bold">Solicitar Agendamento</h5>
    </nav>

    <div class="p-4 p-lg-5">
        <div class="row justify-content-center">
            <div class="col-lg-7">

                <div class="card p-4 border-0 shadow-sm">
                    <h5 class="fw-bold mb-4">Novo Agendamento</h5>

                    <!-- ✅ FORM EXPLÍCITO -->
                    <form id="agendaCreateForm"
                          method="post"
                          action="/teamOdonto/public/api.php?api=agenda">

                        <!-- BUSCA PACIENTE -->
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Paciente</label>
                            <input type="text"
                                   class="form-control"
                                   id="buscaPaciente"
                                   placeholder="Buscar paciente..."
                                   autocomplete="off">
                            <div class="list-group mt-1 d-none"
                                 id="listaPacientes"></div>

                            <!-- ✅ name definido -->
                            <input type="hidden"
                                   id="paciente_id"
                                   name="paciente_id"
                                   required>
                        </div>

                        <!-- BUSCA DENTISTA -->
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Dentista</label>
                            <input type="text"
                                   class="form-control"
                                   id="buscaDentista"
                                   placeholder="Buscar dentista..."
                                   autocomplete="off">
                            <div class="list-group mt-1 d-none"
                                 id="listaDentistas"></div>

                            <!-- ✅ name definido -->
                            <input type="hidden"
                                   id="dentista_id"
                                   name="dentista_id"
                                   required>
                        </div>

                        <!-- DATA -->
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Data</label>
                            <input type="date"
                                   class="form-control"
                                   id="data"
                                   name="data"
                                   required>
                        </div>

                        <!-- HORA -->
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Hora</label>
                            <input type="time"
                                   class="form-control"
                                   id="hora"
                                   name="hora"
                                   required>
                        </div>

                        <button type="submit"
                                class="btn btn-primary w-100 fw-bold">
                            Solicitar Agendamento
                        </button>
                    </form>

                    <div id="agendaCreateMsg" class="mt-3"></div>
                </div>

            </div>
        </div>
    </div>
</main>

<script src="/teamOdonto/public/js/agenda/agenda-create.js"></script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
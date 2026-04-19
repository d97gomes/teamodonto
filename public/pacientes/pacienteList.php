<?php include '../layout/sidebar.php'; ?>

<h3>Pacientes</h3>

<!-- Barra de ações -->
<div class="d-flex justify-content-between align-items-center mb-3">

    <a href="pacienteCreate.php" class="btn btn-primary">
        ➕ Novo Paciente
    </a>

    <!-- Busca apenas visual por enquanto -->
    <input
        type="text"
        class="form-control w-25"
        placeholder="Buscar por nome ou CPF"
        disabled
    >
</div>

<!-- Tabela -->
<table class="table table-bordered table-striped">
    <thead class="table-light">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>CPF</th>
            <th>Telefone</th>
            <th>Ações</th>
        </tr>
    </thead>

    <!-- ✅ Tbody dinâmico -->
    <tbody id="tabelaPacientes"></tbody>
</table>

<!-- Paginação (visual por enquanto) -->
<nav>
    <ul class="pagination justify-content-center">
        <li class="page-item disabled">
            <a class="page-link">Anterior</a>
        </li>
        <li class="page-item active">
            <a class="page-link">1</a>
        </li>
        <li class="page-item disabled">
            <a class="page-link">Próximo</a>
        </li>
    </ul>
</nav>

<!-- ✅ Ordem correta dos scripts -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="../js/paciente.js"></script>

<?php include '../layout/footer.php'; ?>
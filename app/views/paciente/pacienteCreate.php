<?php
// VIEW PURA 'Cadastro de Paciente';// VIEW PURA — CREATE
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
require_once __DIR__ . '/../includes/sidebar.php';
?>

<div class="container py-4">

    <h3 class="mb-4">Cadastro de Paciente</h3>

    <form id="formPaciente">

        <h5>Dados Pessoais</h5>

        <input class="form-control mb-2"
               name="nome"
               placeholder="Nome completo"
               required>

        <input class="form-control mb-2"
               name="cpf"
               placeholder="CPF"
               required>

        <input class="form-control mb-2"
               name="telefone"
               placeholder="Telefone">

        <input class="form-control mb-2"
               name="email"
               placeholder="Email">

        <input type="date"
               class="form-control mb-3"
               name="data_nascimento">

        <h5>Endereço</h5>

        <input class="form-control mb-2"
               name="cep"
               placeholder="CEP">

        <input class="form-control mb-2"
               name="logradouro"
               placeholder="Rua"
               required>

        <input class="form-control mb-2"
               name="numero"
               placeholder="Número">

        <input class="form-control mb-2"
               name="complemento"
               placeholder="Complemento">

        <input class="form-control mb-2"
               name="bairro"
               placeholder="Bairro"
               required>

        <input class="form-control mb-2"
               name="cidade"
               placeholder="Cidade"
               required>

        <input class="form-control mb-3"
               name="estado"
               placeholder="Estado"
               required>

        <button type="submit" class="btn btn-primary">
            Salvar Paciente
        </button>

        <a href="/teamOdonto/public/index.php?page=paciente-list"
           class="btn btn-secondary">
            Cancelar
        </a>

    </form>

</div>
<script src="/teamOdonto/public/js/paciente/paciente-Create.js"></script>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>

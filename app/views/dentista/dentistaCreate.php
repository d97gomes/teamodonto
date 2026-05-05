<?php
if (!defined('APP_ROUTER')) {
    header('Location: /teamOdonto/public/index.php?page=login');
    exit;
}

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
require_once __DIR__ . '/../includes/sidebar.php';
?>

<div class="container py-4">

    <h3 class="mb-4">Cadastro de Dentista</h3>

    <form id="formDentista">

        <h5>Dados Pessoais</h5>

        <input class="form-control mb-2"
               name="nome"
               placeholder="Nome completo"
               required>

        <input class="form-control mb-2"
               name="cpf"
               placeholder="CPF"
               required>

        <select class="form-select mb-2"
                name="sexo"
                required>
            <option value="">Selecione o sexo</option>
            <option value="MASCULINO">Masculino</option>
            <option value="FEMININO">Feminino</option>
            <option value="OUTROS">Outros</option>
        </select>

        <input class="form-control mb-2"
               name="telefone"
               placeholder="Telefone">

        <input class="form-control mb-3"
               name="email"
               placeholder="Email">
       

        <input class="form-control mb-2"
               name="cro"
               placeholder="CRO"
               required>

        <input class="form-control mb-3"
               name="especialidade"
               placeholder="Especialidade"
               required>

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
            Salvar Dentista
        </button>

        <a href="/teamOdonto/public/index.php?page=dentista-list"
           class="btn btn-secondary">
            Cancelar
        </a>

    </form>

</div>

<script src="/teamOdonto/public/js/dentista/dentista-create.js"></script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
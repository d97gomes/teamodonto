<?php include '../layout/sidebar.php'; ?>

<h3>Novo Paciente</h3>

<!-- Mensagens de feedback -->
<div id="mensagem"></div>

<form id="formPaciente">

    <h5 class="mt-4">Dados do Paciente</h5>

    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label">Nome</label>
            <input type="text" name="nome" class="form-control" required>
        </div>

        <div class="col-md-3">
            <label class="form-label">CPF</label>
            <input type="text" name="cpf" class="form-control" required>
        </div>

        <div class="col-md-3">
            <label class="form-label">Telefone</label>
            <input type="text" name="telefone" class="form-control">
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label">E-mail</label>
            <input type="email" name="email" class="form-control">
        </div>

        <div class="col-md-3">
            <label class="form-label">Sexo</label>
            <select name="sexo" class="form-select">
                <option value="">Selecione</option>
                <option value="M">Masculino</option>
                <option value="F">Feminino</option>
            </select>
        </div>

        <div class="col-md-3">
            <label class="form-label">Data de Nascimento</label>
            <input type="date" name="dataNascimento" class="form-control">
        </div>
    </div>

    <h5 class="mt-4">Endereço</h5>

    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label">Rua</label>
            <input type="text" name="rua" class="form-control" required>
        </div>

        <div class="col-md-2">
            <label class="form-label">Número</label>
            <input type="text" name="numero" class="form-control">
        </div>

        <div class="col-md-4">
            <label class="form-label">Bairro</label>
            <input type="text" name="bairro" class="form-control" required>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-4">
            <label class="form-label">Complemento</label>
            <input type="text" name="complemento" class="form-control">
        </div>

        <div class="col-md-4">
            <label class="form-label">Cidade</label>
            <input type="text" name="cidade" class="form-control" required>
        </div>

        <div class="col-md-2">
            <label class="form-label">Estado</label>
            <input type="text" name="estado" class="form-control" maxlength="2" required>
        </div>

        <div class="col-md-2">
            <label class="form-label">CEP</label>
            <input type="text" name="cep" class="form-control">
        </div>
    </div>

    <!-- ✅ Botões -->
    <div class="mt-4 d-flex gap-2">
        <button type="submit" class="btn btn-primary">
            Salvar
        </button>

        <button type="reset" class="btn btn-warning">
            Limpar
        </button>

        <a href="pacienteList.php" class="btn btn-secondary">
            Voltar
        </a>
    </div>

</form>

<!-- Axios + JS do módulo -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="../js/paciente.js"></script>

<?php include '../layout/footer.php'; ?>

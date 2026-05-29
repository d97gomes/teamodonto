<?php
if (!defined('APP_ROUTER')) {
    header('Location: /teamOdonto/public/index.php?page=login');
    exit;
}

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
require_once __DIR__ . '/../includes/sidebar.php';
?>

<h3>Novo Orçamento</h3>

<div class="mb-3">
    <a href="index.php?page=orcamentoList" class="btn btn-light">
        Voltar
    </a>
</div>

<!-- ======================
     DADOS DO ORÇAMENTO
====================== -->
<div class="card mb-4">
    <div class="card-header fw-bold">Dados do Orçamento</div>
    <div class="card-body">
        <div class="row g-3">

            <!-- PACIENTE -->
            <div class="col-md-6 position-relative">
                <label class="form-label">Paciente</label>
                <input type="text"
                       id="pacienteBusca"
                       class="form-control"
                       placeholder="Digite nome ou CPF"
                       autocomplete="off">
                <input type="hidden" id="pacienteId">
                <ul id="pacienteResultados"
                    class="list-group position-absolute w-100 d-none"
                    style="z-index: 1000"></ul>
            </div>

            <!-- DENTISTA -->
            <div class="col-md-6 position-relative">
                <label class="form-label">Dentista</label>
                <input type="text"
                       id="dentistaBusca"
                       class="form-control"
                       placeholder="Digite nome ou CPF"
                       autocomplete="off">
                <input type="hidden" id="dentistaId">
                <ul id="dentistaResultados"
                    class="list-group position-absolute w-100 d-none"
                    style="z-index: 1000"></ul>
            </div>

        </div>
    </div>
</div>

<!-- ======================
     ITENS DO ORÇAMENTO
====================== -->
<div class="card mb-4">
    <div class="card-header fw-bold">Itens do Orçamento</div>
    <div class="card-body">

        <!-- FORM ITEM -->
        <div class="row g-3 align-items-end mb-3">
            <div class="col-md-4">
                <label class="form-label">Procedimento</label>
                <select id="procedimentoSelect" class="form-select">
                    <option value="">Selecione</option>
                </select>
            </div>

<div class="col-md-2">
    <label class="form-label">Dente</label>
    <select id="denteSelect" class="form-select">
        <option value="">Selecione</option>

        <optgroup label="Superior Direito">
            <option value="11">11</option>
            <option value="12">12</option>
            <option value="13">13</option>
            <option value="14">14</option>
            <option value="15">15</option>
            <option value="16">16</option>
            <option value="17">17</option>
            <option value="18">18</option>
        </optgroup>

        <optgroup label="Superior Esquerdo">
            <option value="21">21</option>
            <option value="22">22</option>
            <option value="23">23</option>
            <option value="24">24</option>
            <option value="25">25</option>
            <option value="26">26</option>
            <option value="27">27</option>
            <option value="28">28</option>
        </optgroup>

        <optgroup label="Inferior Esquerdo">
            <option value="31">31</option>
            <option value="32">32</option>
            <option value="33">33</option>
            <option value="34">34</option>
            <option value="35">35</option>
            <option value="36">36</option>
            <option value="37">37</option>
            <option value="38">38</option>
        </optgroup>

        <optgroup label="Inferior Direito">
            <option value="41">41</option>
            <option value="42">42</option>
            <option value="43">43</option>
            <option value="44">44</option>
            <option value="45">45</option>
            <option value="46">46</option>
            <option value="47">47</option>
            <option value="48">48</option>
        </optgroup>
    </select>
</div>

            <div class="col-md-2">
                <label class="form-label">Face</label>
                <select id="faceSelect" class="form-select">
                    <option value="">--</option>
                    <option value="O">O</option>
                    <option value="M">M</option>
                    <option value="D">D</option>
                    <option value="V">V</option>
                    <option value="L">L</option>
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label">Valor (R$)</label>
                <input type="text" id="valorInput" class="form-control" readonly>
            </div>

            <div class="col-md-2">
                <button id="btnAdicionarItem"
                        class="btn btn-success w-100">
                    Adicionar
                </button>
            </div>
        </div>

        <!-- TABELA -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Dente</th>
                    <th>Face</th>
                    <th>Procedimento</th>
                    <th>Valor</th>
                    <th width="80">Ação</th>
                </tr>
            </thead>
            <tbody id="tabelaItens">
                <tr>
                    <td colspan="5" class="text-center">
                        Nenhum item adicionado
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- TOTAL -->
<div class="card mb-4">
    <div class="card-body d-flex justify-content-between">
        <strong>Total</strong>
        <span id="totalOrcamento"
              class="fw-bold text-primary fs-5">
            R$ 0,00
        </span>
    </div>
</div>

<div class="text-end">
    <button id="btnSalvarOrcamento"
            class="btn btn-primary">
        Salvar Orçamento
    </button>
</div>

<script src="/teamOdonto/public/js/orcamento/orcamento-create.js"></script>
``
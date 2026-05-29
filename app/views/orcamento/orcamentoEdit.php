<?php
if (!defined('APP_ROUTER')) {
    header('Location: /teamOdonto/public/index.php?page=login');
    exit;
}

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
require_once __DIR__ . '/../includes/sidebar.php';

$orcamentoId = (int) ($_GET['id'] ?? 0);
?>

<h3>Editar Orçamento</h3>

<div class="mb-3">
    <a href="index.php?page=orcamentoView&id=<?= $orcamentoId ?>"
       class="btn btn-light">
        Voltar
    </a>
</div>

<input type="hidden" id="orcamentoId" value="<?= $orcamentoId ?>">

<!-- ======================
     DADOS DO ORÇAMENTO
====================== -->
<div class="card mb-4">
    <div class="card-header fw-bold">Dados do Orçamento</div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Paciente</label>
                <input type="text" id="pacienteNome"
                       class="form-control" readonly>
            </div>

            <div class="col-md-6">
                <label class="form-label">Dentista</label>
                <input type="text" id="dentistaNome"
                       class="form-control" readonly>
            </div>

            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select id="statusSelect" class="form-select">
                    <option value="aberto">Aberto</option>
                    <option value="aprovado">Aprovado</option>
                    <option value="cancelado">Cancelado</option>
                </select>
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
                <!-- MESMO SELECT FDI DO CREATE -->
                <select id="denteSelect" class="form-select">
                    <option value="">Selecione</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                    <option value="14">14</option>
                    <option value="15">15</option>
                    <option value="16">16</option>
                    <option value="17">17</option>
                    <option value="18">18</option>
                    <option value="21">21</option>
                    <option value="22">22</option>
                    <option value="23">23</option>
                    <option value="24">24</option>
                    <option value="25">25</option>
                    <option value="26">26</option>
                    <option value="27">27</option>
                    <option value="28">28</option>
                    <option value="31">31</option>
                    <option value="32">32</option>
                    <option value="33">33</option>
                    <option value="34">34</option>
                    <option value="35">35</option>
                    <option value="36">36</option>
                    <option value="37">37</option>
                    <option value="38">38</option>
                    <option value="41">41</option>
                    <option value="42">42</option>
                    <option value="43">43</option>
                    <option value="44">44</option>
                    <option value="45">45</option>
                    <option value="46">46</option>
                    <option value="47">47</option>
                    <option value="48">48</option>
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
                <button id="btnAdicionarItem"
                        class="btn btn-success w-100">
                    Adicionar
                </button>
            </div>
        </div>

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
            <tbody id="tabelaItens"></tbody>
        </table>
    </div>
</div>

<div class="card">
    <div class="card-body d-flex justify-content-between">
        <strong>Total</strong>
        <span id="totalOrcamento"
              class="fw-bold text-primary fs-5">
            R$ 0,00
        </span>
    </div>
</div>

<script src="/teamOdonto/public/js/orcamento/orcamento-edit.js"></script>
document.addEventListener('DOMContentLoaded', () => {

    const container = document.getElementById('conteudoAnamnese');
    if (!container) return;

    const params = new URLSearchParams(window.location.search);
    const id = params.get('id');

    if (!id) {
        container.innerHTML = `
            <div class="alert alert-danger text-center">
                Anamnese não encontrada ❌
            </div>
        `;
        return;
    }

    /* =========================
       CARREGAR ANAMNESE
    ========================= */
    axios
        .get(`/teamOdonto/public/api.php?api=anamneses&id=${id}`)
        .then(res => {

            const a = res.data;

            if (!a) {
                container.innerHTML = `
                    <div class="alert alert-danger text-center">
                        Anamnese não encontrada ❌
                    </div>
                `;
                return;
            }

            container.innerHTML = `
                <div class="row g-3">

                    <!-- HISTÓRICO MÉDICO -->
                    <div class="col-md-6">
                        <div class="card shadow-sm p-3">
                            <h6 class="fw-bold mb-3">Histórico Médico</h6>
                            <ul class="mb-0">
                                <li>Diabetes: ${bool(a.diabetes)}</li>
                                <li>Hipertensão: ${bool(a.hipertensao)}</li>
                                <li>Cardíacos: ${bool(a.problemas_cardiacos)}</li>
                                <li>Respiratórios: ${bool(a.problemas_respiratorios)}</li>
                                <li>Infecciosas: ${bool(a.doencas_infecciosas)}</li>
                                <li>Ósseas: ${bool(a.doencas_osseas)}</li>
                                <li>Câncer: ${bool(a.cancer)}</li>
                                <li>Convulsões: ${bool(a.convulsoes)}</li>
                            </ul>
                        </div>
                    </div>

                    <!-- MEDICAMENTOS -->
                    <div class="col-md-6">
                        <div class="card shadow-sm p-3">
                            <h6 class="fw-bold mb-3">Medicamentos e Cirurgias</h6>
                            <ul class="mb-0">
                                <li>Tratamento médico: ${bool(a.em_tratamento_medico)}</li>
                                <li>Medicamentos: ${txt(a.medicamentos_em_uso)}</li>
                                <li>Hospitalizado: ${bool(a.hospitalizado_ou_operado)}</li>
                                <li>Cirurgias: ${txt(a.detalhes_cirurgias)}</li>
                            </ul>
                        </div>
                    </div>

                    <!-- HÁBITOS -->
                    <div class="col-md-6">
                        <div class="card shadow-sm p-3">
                            <h6 class="fw-bold mb-3">Hábitos</h6>
                            <ul class="mb-0">
                                <li>Tabagista: ${bool(a.tabagista)}</li>
                                <li>Tipo: ${txt(a.tipo_tabaco)}</li>
                                <li>Álcool: ${bool(a.consumo_alcool)}</li>
                                <li>Frequência: ${txt(a.frequencia_alcool)}</li>
                            </ul>
                        </div>
                    </div>

                    <!-- HIGIENE -->
                    <div class="col-md-6">
                        <div class="card shadow-sm p-3">
                            <h6 class="fw-bold mb-3">Higiene Bucal</h6>
                            <ul class="mb-0">
                                <li>Escovações por dia: ${a.escovacoes_por_dia ?? 0}</li>
                                <li>Fio dental: ${bool(a.usa_fio_dental)}</li>
                                <li>Bruxismo: ${bool(a.bruxismo)}</li>
                            </ul>
                        </div>
                    </div>

                    <!-- HISTÓRICO FAMILIAR -->
                    <div class="col-md-12">
                        <div class="card shadow-sm p-3">
                            <h6 class="fw-bold mb-3">Histórico Familiar</h6>
                            <p class="mb-0">${txt(a.doencas_hereditarias)}</p>
                        </div>
                    </div>

                    <!-- OBSERVAÇÕES -->
                    <div class="col-md-12">
                        <div class="card shadow-sm p-3">
                            <h6 class="fw-bold mb-3">Observações</h6>
                            <p class="mb-0">${txt(a.observacoes)}</p>
                        </div>
                    </div>

                </div>
            `;

        })
        .catch(() => {
            container.innerHTML = `
                <div class="alert alert-danger text-center">
                    Erro ao carregar anamnese ❌
                </div>
            `;
        });

});

/* =========================
   HELPERS 🔥
========================= */
function bool(valor) {
    return valor
        ? '<span class="text-success fw-bold">Sim</span>'
        : '<span class="text-muted">Não</span>';
}

function txt(valor) {
    return valor || '-';
}
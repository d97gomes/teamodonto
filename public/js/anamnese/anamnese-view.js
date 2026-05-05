document.addEventListener('DOMContentLoaded', async () => {

    const container = document.getElementById('conteudoAnamnese');
    if (!container) return;

    const params = new URLSearchParams(window.location.search);
    const id = params.get('id');

    if (!id) {
        container.innerHTML =
            '<p class="text-danger">Anamnese não encontrada.</p>';
        return;
    }

    try {
        const res = await axios.get(
            `/teamOdonto/public/index.php?api=anamneses&id=${id}`
        );

        const a = res.data;

        container.innerHTML = `
            <h6 class="fw-bold">Histórico Médico</h6>
            <ul>
                <li>Diabetes: ${a.diabetes ? 'Sim' : 'Não'}</li>
                <li>Hipertensão: ${a.hipertensao ? 'Sim' : 'Não'}</li>
                <li>Problemas Cardíacos: ${a.problemas_cardiacos ? 'Sim' : 'Não'}</li>
                <li>Problemas Respiratórios: ${a.problemas_respiratorios ? 'Sim' : 'Não'}</li>
                <li>Doenças Infecciosas: ${a.doencas_infecciosas ? 'Sim' : 'Não'}</li>
                <li>Doenças Ósseas: ${a.doencas_osseas ? 'Sim' : 'Não'}</li>
                <li>Câncer: ${a.cancer ? 'Sim' : 'Não'}</li>
                <li>Convulsões: ${a.convulsoes ? 'Sim' : 'Não'}</li>
            </ul>

            <hr>

            <h6 class="fw-bold">Medicamentos e Cirurgias</h6>
            <ul>
                <li>Em tratamento médico: ${a.em_tratamento_medico ? 'Sim' : 'Não'}</li>
                <li>Medicamentos em uso: ${a.medicamentos_em_uso || '-'}</li>
                <li>Hospitalizado/Operado: ${a.hospitalizado_ou_operado ? 'Sim' : 'Não'}</li>
                <li>Detalhes das cirurgias: ${a.detalhes_cirurgias || '-'}</li>
            </ul>

            <hr>

            <h6 class="fw-bold">Hábitos</h6>
            <ul>
                <li>Tabagista: ${a.tabagista ? 'Sim' : 'Não'}</li>
                <li>Tipo de tabaco: ${a.tipo_tabaco || '-'}</li>
                <li>Consumo de álcool: ${a.consumo_alcool ? 'Sim' : 'Não'}</li>
                <li>Frequência de álcool: ${a.frequencia_alcool || '-'}</li>
            </ul>

            <hr>

            <h6 class="fw-bold">Higiene Bucal</h6>
            <ul>
                <li>Escovações por dia: ${a.escovacoes_por_dia}</li>
                <li>Usa fio dental: ${a.usa_fio_dental ? 'Sim' : 'Não'}</li>
                <li>Bruxismo: ${a.bruxismo ? 'Sim' : 'Não'}</li>
            </ul>

            <hr>

            <h6 class="fw-bold">Histórico Familiar</h6>
            <p>${a.doencas_hereditarias || '-'}</p>

            <hr>

            <h6 class="fw-bold">Observações</h6>
            <p>${a.observacoes || '-'}</p>
        `;

    } catch (err) {
        container.innerHTML =
            '<p class="text-danger">Erro ao carregar anamnese.</p>';
    }
});
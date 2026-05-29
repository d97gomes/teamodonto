document.addEventListener('DOMContentLoaded', () => {

    const form = document.getElementById('formAnamneseEdit');
    if (!form) return;

    const id = form.dataset.id;

    /* =========================
       CARREGAR ANAMNESE
    ========================= */
    axios
        .get(`/teamOdonto/public/api.php?api=anamneses&id=${id}`)
        .then(res => {
            const a = res.data;

            /* HISTÓRICO MÉDICO */
            document.getElementById('diabetes').checked = a.diabetes == 1;
            document.getElementById('hipertensao').checked = a.hipertensao == 1;
            document.getElementById('problemas_cardiacos').checked = a.problemas_cardiacos == 1;
            document.getElementById('problemas_respiratorios').checked = a.problemas_respiratorios == 1;
            document.getElementById('doencas_infecciosas').checked = a.doencas_infecciosas == 1;
            document.getElementById('doencas_osseas').checked = a.doencas_osseas == 1;
            document.getElementById('cancer').checked = a.cancer == 1;
            document.getElementById('convulsoes').checked = a.convulsoes == 1;

            /* MEDICAMENTOS E CIRURGIAS */
            document.getElementById('em_tratamento_medico').checked = a.em_tratamento_medico == 1;
            document.getElementById('medicamentos_em_uso').value = a.medicamentos_em_uso ?? '';
            document.getElementById('hospitalizado_ou_operado').checked = a.hospitalizado_ou_operado == 1;
            document.getElementById('detalhes_cirurgias').value = a.detalhes_cirurgias ?? '';

            /* HÁBITOS */
            document.getElementById('tabagista').checked = a.tabagista == 1;
            document.getElementById('tipo_tabaco').value = a.tipo_tabaco ?? '';
            document.getElementById('consumo_alcool').checked = a.consumo_alcool == 1;
            document.getElementById('frequencia_alcool').value = a.frequencia_alcool ?? '';

            /* HIGIENE BUCAL */
            document.getElementById('escovacoes_por_dia').value = a.escovacoes_por_dia ?? 0;
            document.getElementById('usa_fio_dental').checked = a.usa_fio_dental == 1;
            document.getElementById('bruxismo').checked = a.bruxismo == 1;

            /* OUTROS */
            document.getElementById('doencas_hereditarias').value = a.doencas_hereditarias ?? '';
            document.getElementById('observacoes').value = a.observacoes ?? '';
        })
        .catch(() => {
            alert('Erro ao carregar anamnese');
            window.location.href =
                '/teamOdonto/public/index.php?page=anamnese-list';
        });

    /* =========================
       UPDATE DA ANAMNESE
    ========================= */
    form.addEventListener('submit', e => {
        e.preventDefault();

        const dados = {
            diabetes: document.getElementById('diabetes').checked ? 1 : 0,
            hipertensao: document.getElementById('hipertensao').checked ? 1 : 0,
            problemas_cardiacos: document.getElementById('problemas_cardiacos').checked ? 1 : 0,
            problemas_respiratorios: document.getElementById('problemas_respiratorios').checked ? 1 : 0,
            doencas_infecciosas: document.getElementById('doencas_infecciosas').checked ? 1 : 0,
            doencas_osseas: document.getElementById('doencas_osseas').checked ? 1 : 0,
            cancer: document.getElementById('cancer').checked ? 1 : 0,
            convulsoes: document.getElementById('convulsoes').checked ? 1 : 0,

            em_tratamento_medico: document.getElementById('em_tratamento_medico').checked ? 1 : 0,
            medicamentos_em_uso: document.getElementById('medicamentos_em_uso').value.trim(),
            hospitalizado_ou_operado: document.getElementById('hospitalizado_ou_operado').checked ? 1 : 0,
            detalhes_cirurgias: document.getElementById('detalhes_cirurgias').value.trim(),

            tabagista: document.getElementById('tabagista').checked ? 1 : 0,
            tipo_tabaco: document.getElementById('tipo_tabaco').value.trim(),
            consumo_alcool: document.getElementById('consumo_alcool').checked ? 1 : 0,
            frequencia_alcool: document.getElementById('frequencia_alcool').value.trim(),

            escovacoes_por_dia: document.getElementById('escovacoes_por_dia').value,
            usa_fio_dental: document.getElementById('usa_fio_dental').checked ? 1 : 0,
            bruxismo: document.getElementById('bruxismo').checked ? 1 : 0,

            doencas_hereditarias: document.getElementById('doencas_hereditarias').value.trim(),
            observacoes: document.getElementById('observacoes').value.trim()
        };

        axios
            .put(`/teamOdonto/public/api.php?api=anamneses&id=${id}`, dados)
            .then(res => {
                if (res.data.success) {
                    alert('Anamnese atualizada com sucesso!');
                    window.location.href =
                        '/teamOdonto/public/index.php?page=anamnese-list';
                } else {
                    alert('Erro ao atualizar anamnese.');
                }
            })
            .catch(() => {
                alert('Erro de comunicação com o servidor.');
            });
    });

});

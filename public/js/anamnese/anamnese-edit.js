document.addEventListener('DOMContentLoaded', () => {

    const form = document.getElementById('formAnamneseEdit');
    if (!form) return;

    const btnSubmit = form.querySelector('button[type="submit"]');
    const id = form.dataset.id;

    if (!id) {
        mostrarMensagem('ID da anamnese não encontrado ❌', 'danger');
        return;
    }

    /* =========================
       FUNÇÃO SEGURA 🔥
    ========================= */
    function setValue(id, valor) {
        const el = document.getElementById(id);

        if (!el) return;

        if (el.type === 'checkbox') {
            el.checked = valor == 1;
        } else {
            el.value = valor ?? '';
        }
    }

    /* =========================
       CARREGAR DADOS ✅
    ========================= */
    axios
        .get(`/teamOdonto/public/api.php?api=anamneses&id=${id}`)
        .then(res => {

            const a = res.data;

            if (!a) {
                mostrarMensagem('Anamnese não encontrada ❌', 'danger');
                return;
            }

            /* HISTÓRICO */
            setValue('diabetes', a.diabetes);
            setValue('hipertensao', a.hipertensao);
            setValue('problemas_cardiacos', a.problemas_cardiacos);
            setValue('problemas_respiratorios', a.problemas_respiratorios);
            setValue('doencas_infecciosas', a.doencas_infecciosas);
            setValue('doencas_osseas', a.doencas_osseas);
            setValue('cancer', a.cancer);
            setValue('convulsoes', a.convulsoes);

            /* CAMPOS */
            setValue('alergias', a.alergias);
            setValue('outras_doencas', a.outras_doencas);

            /* MEDICAMENTOS */
            setValue('em_tratamento_medico', a.em_tratamento_medico);
            setValue('medicamentos_em_uso', a.medicamentos_em_uso);
            setValue('hospitalizado_ou_operado', a.hospitalizado_ou_operado);
            setValue('detalhes_cirurgias', a.detalhes_cirurgias);

            /* HÁBITOS */
            setValue('tabagista', a.tabagista);
            setValue('tipo_tabaco', a.tipo_tabaco);
            setValue('consumo_alcool', a.consumo_alcool);
            setValue('frequencia_alcool', a.frequencia_alcool);

            /* HIGIENE */
            setValue('escovacoes_por_dia', a.escovacoes_por_dia);
            setValue('usa_fio_dental', a.usa_fio_dental);
            setValue('bruxismo', a.bruxismo);

            /* FINAL */
            setValue('doencas_hereditarias', a.doencas_hereditarias);
            setValue('observacoes', a.observacoes);

        })
        .catch(err => {
            console.error(err);
            mostrarMensagem('Erro ao carregar anamnese ❌', 'danger');
        });

    /* =========================
       UPDATE ✅
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

            alergias: document.getElementById('alergias')?.value.trim() ?? '',
            outras_doencas: document.getElementById('outras_doencas')?.value.trim() ?? '',

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

        /* ===== LOADING ===== */
        btnSubmit.disabled = true;
        btnSubmit.innerHTML = `
            <span class="spinner-border spinner-border-sm me-1"></span>
            Salvando...
        `;

        axios
            .put(`/teamOdonto/public/api.php?api=anamneses&id=${id}`, dados)
            .then(res => {

                if (res.data.success) {

                    mostrarMensagem('Anamnese atualizada com sucesso ✅', 'success');

                    setTimeout(() => {
                        window.location.href =
                            '/teamOdonto/public/index.php?page=anamnese-list';
                    }, 1200);

                } else {
                    mostrarMensagem('Erro ao atualizar anamnese ❌', 'danger');
                }

            })
            .catch(err => {
                console.error(err);
                mostrarMensagem('Erro de comunicação com o servidor ❌', 'danger');
            })
            .finally(() => {
                btnSubmit.disabled = false;
                btnSubmit.innerHTML = 'Salvar';
            });
    });

});

/* =========================
   ALERTA PADRÃO 🔥
========================= */
function mostrarMensagem(texto, tipo = 'success') {

    let alerta = document.getElementById('alertaSistema');

    if (!alerta) {
        alerta = document.createElement('div');
        alerta.id = 'alertaSistema';
        alerta.className = `alert alert-${tipo} mt-3`;

        document.querySelector('.main-content')?.prepend(alerta);
    }

    alerta.className = `alert alert-${tipo} mt-3`;
    alerta.innerHTML = texto;

    setTimeout(() => alerta.remove(), 3000);
}
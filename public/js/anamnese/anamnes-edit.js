document.addEventListener('DOMContentLoaded', async () => {

    const form = document.getElementById('formAnamneseEdit');
    if (!form) return;

    const id = form.dataset.id;

    /* =========================
       CARREGAR ANAMNESE
    ========================= */
    try {
        const res = await axios.get(
            `/teamOdonto/public/index.php?api=anamneses&id=${id}`
        );

        const a = res.data;

        document.getElementById('diabetes').checked = a.diabetes == 1;
        document.getElementById('hipertensao').checked = a.hipertensao == 1;
        document.getElementById('problemas_cardiacos').checked = a.problemas_cardiacos == 1;
        document.getElementById('problemas_respiratorios').checked = a.problemas_respiratorios == 1;
        document.getElementById('doencas_infecciosas').checked = a.doencas_infecciosas == 1;
        document.getElementById('doencas_osseas').checked = a.doencas_osseas == 1;
        document.getElementById('cancer').checked = a.cancer == 1;
        document.getElementById('convulsoes').checked = a.convulsoes == 1;

        document.getElementById('alergias').value = a.alergias ?? '';
        document.getElementById('medicamentos_em_uso').value = a.medicamentos_em_uso ?? '';
        document.getElementById('observacoes').value = a.observacoes ?? '';

    } catch (err) {
        alert('Erro ao carregar anamnese');
        window.location.href = '/teamOdonto/public/index.php?page=anamnese-list';
        return;
    }

    /* =========================
       UPDATE
    ========================= */
    form.addEventListener('submit', async e => {
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
            alergias: document.getElementById('alergias').value.trim(),
            medicamentos_em_uso: document.getElementById('medicamentos_em_uso').value.trim(),
            observacoes: document.getElementById('observacoes').value.trim()
        };

        try {
            const res = await axios.put(
                `/teamOdonto/public/index.php?api=anamneses&id=${id}`,
                dados
            );

            if (res.data.success) {
                alert('Anamnese atualizada com sucesso!');
                window.location.href =
                    '/teamOdonto/public/index.php?page=anamnese-list';
            } else {
                alert('Erro ao atualizar anamnese.');
            }

        } catch (err) {
            alert('Erro de comunicação com o servidor.');
        }
    });
});
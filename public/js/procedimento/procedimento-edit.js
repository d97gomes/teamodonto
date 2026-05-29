document.addEventListener('DOMContentLoaded', () => {

    const id = document.getElementById('procedimentoId').value;
    const form = document.getElementById('formProcedimentoEdit');

    if (!id || !form) return;

    /* =========================
       CARREGAR DADOS
    ========================= */
    axios
        .get(`/teamOdonto/public/api.php?api=procedimentos&id=${id}`)
        .then(response => {
            const p = response.data;

            document.getElementById('nome').value = p.nome;
            document.getElementById('descricao').value = p.descricao ?? '';
            document.getElementById('valor').value = p.valor;
        })
        .catch(error => {
            console.error(error);
            alert('Erro ao carregar procedimento.');
        });

    /* =========================
       SALVAR (UPDATE)
    ========================= */
    form.addEventListener('submit', e => {
        e.preventDefault();

        const dados = Object.fromEntries(
            new FormData(form)
        );

        axios
            .put(`/teamOdonto/public/api.php?api=procedimentos&id=${id}`, dados)
            .then(response => {

                if (response.data.success) {
                    alert('Procedimento atualizado!');
                    window.location.href =
                        '/teamOdonto/public/index.php?page=procedimento-list';
                } else {
                    alert(response.data.message || 'Erro ao atualizar.');
                }
            })
            .catch(error => {
                console.error(error);
                alert('Erro de comunicação com o servidor.');
            });
    });

});
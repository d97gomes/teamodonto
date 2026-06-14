document.addEventListener('DOMContentLoaded', () => {

    const id = document.getElementById('procedimentoId')?.value;
    const form = document.getElementById('formProcedimentoEdit');

    if (!id || !form) return;

    const btnSubmit = form.querySelector('button[type="submit"]');

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

            mostrarMensagem('Erro ao carregar procedimento ❌', 'danger');
        });

    /* =========================
       SALVAR (UPDATE)
    ========================= */
    form.addEventListener('submit', e => {
        e.preventDefault();

        const dados = Object.fromEntries(
            new FormData(form)
        );

        // 🔒 feedback visual
        btnSubmit.disabled = true;
        btnSubmit.innerHTML = `
            <span class="spinner-border spinner-border-sm"></span>
            Salvando...
        `;

        axios
            .put(`/teamOdonto/public/api.php?api=procedimentos&id=${id}`, dados)
            .then(response => {

                if (response.data.success) {

                    mostrarMensagem('Procedimento atualizado com sucesso ✅', 'success');

                    setTimeout(() => {
                        window.location.href =
                            '/teamOdonto/public/index.php?page=procedimento-list';
                    }, 1200);

                } else {
                    mostrarMensagem(response.data.message || 'Erro ao atualizar ❌', 'danger');
                }

            })
            .catch(error => {
                console.error(error);
                mostrarMensagem('Erro de comunicação com o servidor ❌', 'danger');
            })
            .finally(() => {

                btnSubmit.disabled = false;
                btnSubmit.innerHTML = `Salvar`;

            });
    });

    /* =========================
       MENSAGEM PADRONIZADA 🔥
    ========================= */
    function mostrarMensagem(texto, tipo = 'success') {

        let alerta = document.getElementById('alertaSistema');

        if (!alerta) {
            alerta = document.createElement('div');
            alerta.id = 'alertaSistema';
            alerta.className = `alert alert-${tipo} mt-3`;

            form.prepend(alerta);
        }

        alerta.className = `alert alert-${tipo} mt-3`;
        alerta.innerHTML = texto;

        setTimeout(() => {
            alerta.remove();
        }, 3000);
    }

});
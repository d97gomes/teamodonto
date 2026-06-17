document.addEventListener('DOMContentLoaded', () => {

    const form = document.getElementById('formOrcamentoEdit');
    if (!form) return;

    const btnSubmit = form.querySelector('button[type="submit"]');

    const params = new URLSearchParams(window.location.search);
    const id = params.get('id');

    if (!id) {
        mostrarMensagem('ID do orçamento não informado ❌', 'danger');
        return;
    }

    let itens = []; // 🔥 lista de itens

    /* =========================
       CARREGAR ORÇAMENTO
    ========================= */
    axios
        .get(`/teamOdonto/public/api.php?api=orcamentos&id=${id}`)
        .then(res => {

            const dados = res.data;

            // ✅ preencher campos do form
            for (let key in dados) {
                const el = form.querySelector(`[name="${key}"]`);
                if (el) el.value = dados[key];
            }

            // ✅ itens (IMPORTANTE)
            itens = dados.itens || [];

            atualizarTabela();

        })
        .catch(err => {
            console.error(err);
            mostrarMensagem('Erro ao carregar orçamento ❌', 'danger');
        });

    /* =========================
       ADICIONAR ITEM
    ========================= */
    document.getElementById('btnAddItem')?.addEventListener('click', () => {

        const procedimento = document.getElementById('procedimento').value;
        const valor = document.getElementById('valor').value;

        if (!procedimento || !valor) {
            mostrarMensagem('Selecione procedimento e valor ❌', 'danger');
            return;
        }

        itens.push({
            procedimento,
            valor
        });

        atualizarTabela();

        document.getElementById('procedimento').value = '';
        document.getElementById('valor').value = '';
    });

    /* =========================
       ATUALIZAR TABELA
    ========================= */
    function atualizarTabela() {

        const tbody = document.getElementById('listaItens');
        tbody.innerHTML = '';

        if (!itens.length) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="3" class="text-center text-muted">
                        Nenhum item adicionado
                    </td>
                </tr>
            `;
            return;
        }

        itens.forEach((item, index) => {

            const tr = document.createElement('tr');

            tr.innerHTML = `
                <td>${item.procedimento}</td>
                <td>R$ ${item.valor}</td>
                <td>
                    <button class="btn btn-sm btn-danger">
                        Remover
                    </button>
                </td>
            `;

            tr.querySelector('button').addEventListener('click', () => {
                itens.splice(index, 1);
                atualizarTabela();
            });

            tbody.appendChild(tr);
        });
    }

    /* =========================
       SALVAR (PUT)
    ========================= */
    form.addEventListener('submit', e => {
        e.preventDefault();

        if (!itens.length) {
            mostrarMensagem('Adicione pelo menos um item ❌', 'danger');
            return;
        }

        const dados = {
            ...Object.fromEntries(new FormData(form)),
            itens
        };

        btnSubmit.disabled = true;
        btnSubmit.innerHTML = `
            <span class="spinner-border spinner-border-sm me-1"></span>
            Salvando...
        `;

        axios
            .put(`/teamOdonto/public/api.php?api=orcamentos&id=${id}`, dados)
            .then(res => {

                if (res.data.success) {

                    mostrarMensagem('Orçamento atualizado com sucesso ✅');

                    setTimeout(() => {
                        window.location.href =
                            '/teamOdonto/public/index.php?page=orcamento-list';
                    }, 1200);

                } else {
                    mostrarMensagem('Erro ao atualizar orçamento ❌', 'danger');
                }

            })
            .catch(err => {
                console.error(err);
                mostrarMensagem('Erro no servidor ❌', 'danger');
            })
            .finally(() => {
                btnSubmit.disabled = false;
                btnSubmit.innerHTML = 'Salvar';
            });

    });

});

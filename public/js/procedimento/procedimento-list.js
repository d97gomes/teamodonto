document.addEventListener('DOMContentLoaded', () => {

    const tabela = document.querySelector('#tabelaProcedimentos tbody');
    if (!tabela) return;

    carregarProcedimentos();

    /* =========================
       CARREGAR PROCEDIMENTOS
    ========================= */
    function carregarProcedimentos() {

        axios
            .get('/teamOdonto/public/api.php?api=procedimentos')
            .then(response => {

                const dados = response.data;

                if (!Array.isArray(dados)) {
                    throw new Error('Resposta inválida da API');
                }

                tabela.innerHTML = '';

                if (!dados.length) {
                    tabela.innerHTML = `
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">
                                Nenhum procedimento cadastrado
                            </td>
                        </tr>
                    `;
                    return;
                }

                dados.forEach(proc => {
                    const tr = document.createElement('tr');

                    tr.innerHTML = `
                        <td>${proc.nome}</td>

                        <td class="fw-bold">
                            R$ ${Number(proc.valor).toFixed(2).replace('.', ',')}
                        </td>

                        <!-- ✅ COLUNA AÇÕES PADRÃO -->
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">

                                <a href="index.php?page=procedimento-edit&id=${proc.id}"
                                   class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <button class="btn btn-sm btn-outline-danger btn-excluir"
                                        data-id="${proc.id}">
                                    <i class="bi bi-trash"></i>
                                </button>

                            </div>
                        </td>
                    `;

                    tabela.appendChild(tr);
                });

                ativarExcluir();
            })
            .catch(error => {
                console.error(error);
                tabela.innerHTML = `
                    <tr>
                        <td colspan="3" class="text-center text-danger py-4">
                            Erro ao carregar procedimentos
                        </td>
                    </tr>
                `;
            });
    }

    /* =========================
       EXCLUIR PROCEDIMENTO
    ========================= */
    function ativarExcluir() {
        document.querySelectorAll('.btn-excluir').forEach(botao => {
            botao.addEventListener('click', () => {

                const id = botao.dataset.id;

                if (!confirm('Deseja excluir este procedimento?')) return;

                axios
                    .delete(`/teamOdonto/public/api.php?api=procedimentos&id=${id}`)
                    .then(response => {
                        if (response.data.success) {
                            carregarProcedimentos();
                        } else {
                            alert(response.data.message || 'Erro ao excluir.');
                        }
                    })
                    .catch(error => {
                        console.error(error);
                        alert('Erro de comunicação com o servidor.');
                    });
            });
        });
    }

});

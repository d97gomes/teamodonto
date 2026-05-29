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
                            <td colspan="3" class="text-center">
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
                        <td>R$ ${Number(proc.valor).toFixed(2)}</td>
                        <td>
                            <a href="index.php?page=procedimento-edit&id=${proc.id}"
                               class="btn btn-sm btn-warning me-1">
                                Editar
                            </a>

                            <button class="btn btn-sm btn-danger btn-excluir"
                                    data-id="${proc.id}">
                                Excluir
                            </button>
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
                        <td colspan="3" class="text-center text-danger">
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
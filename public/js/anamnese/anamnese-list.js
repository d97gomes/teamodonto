document.addEventListener('DOMContentLoaded', () => {

    const tbody = document.getElementById('listaAnamneses');
    const paginacao = document.getElementById('paginacaoAnamneses');

    if (!tbody) return;

    let paginaAtual = 1;

    carregarAnamneses(paginaAtual);

    /* =========================
       CARREGAR ANAMNESES
    ========================= */
    function carregarAnamneses(pagina) {

        axios
            .get(`/teamOdonto/public/api.php?api=anamneses&pagina=${pagina}`)
            .then(response => {

                const { dados, total, limite } = response.data;
                paginaAtual = pagina;

                tbody.innerHTML = '';

                if (!dados || dados.length === 0) {
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                Nenhuma anamnese encontrada.
                            </td>
                        </tr>
                    `;
                    return;
                }

                dados.forEach(a => {
                    const tr = document.createElement('tr');

                    tr.innerHTML = `
                        <td>${formatarData(a.data_registro)}</td>

                        <td>${a.paciente_nome}</td>

                        <td>${a.dentista_nome}</td>

                        <!-- ✅ AÇÕES PADRONIZADAS -->
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">

                                <a href="/teamOdonto/public/index.php?page=anamnese-view&id=${a.id}"
                                   class="btn btn-sm btn-outline-info"
                                   title="Visualizar">
                                    <i class="bi bi-eye"></i>
                                </a>

                                <a href="/teamOdonto/public/index.php?page=anamnese-edit&id=${a.id}"
                                   class="btn btn-sm btn-outline-warning"
                                   title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <button class="btn btn-sm btn-outline-danger btn-excluir"
                                        data-id="${a.id}"
                                        title="Excluir">
                                    <i class="bi bi-trash"></i>
                                </button>

                            </div>
                        </td>
                    `;

                    tbody.appendChild(tr);
                });

                montarPaginacao(total, limite);
                ativarExcluir();
            })
            .catch(error => {
                console.error(error);
                tbody.innerHTML = `
                    <tr>
                        <td colspan="4" class="text-center text-danger py-4">
                            Erro ao carregar anamneses.
                        </td>
                    </tr>
                `;
            });
    }

    /* =========================
       PAGINAÇÃO
    ========================= */
    function montarPaginacao(total, limite) {
        paginacao.innerHTML = '';

        const totalPaginas = Math.ceil(total / limite);

        for (let i = 1; i <= totalPaginas; i++) {
            const li = document.createElement('li');

            li.className = `page-item ${i === paginaAtual ? 'active' : ''}`;

            li.innerHTML = `<a class="page-link" href="#">${i}</a>`;

            li.addEventListener('click', e => {
                e.preventDefault();
                carregarAnamneses(i);
            });

            paginacao.appendChild(li);
        }
    }

    /* =========================
       EXCLUIR ANAMNESE
    ========================= */
    function ativarExcluir() {
        document.querySelectorAll('.btn-excluir').forEach(btn => {
            btn.addEventListener('click', () => {

                const id = btn.dataset.id;

                if (!confirm('Deseja realmente excluir esta anamnese?')) return;

                axios
                    .delete(`/teamOdonto/public/api.php?api=anamneses&id=${id}`)
                    .then(response => {
                        if (response.data.success) {
                            carregarAnamneses(paginaAtual);
                        } else {
                            alert('Erro ao excluir anamnese.');
                        }
                    })
                    .catch(error => {
                        console.error(error);
                        alert('Erro de comunicação com o servidor.');
                    });
            });
        });
    }

    /* =========================
       FORMATA DATA
    ========================= */
    function formatarData(data) {
        const d = new Date(data.replace(' ', 'T'));
        return d.toLocaleDateString('pt-BR');
    }

});
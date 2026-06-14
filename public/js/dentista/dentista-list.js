document.addEventListener('DOMContentLoaded', () => {

    const tbody = document.getElementById('listaDentistas');
    if (!tbody) return;

    carregarDentistas();

    /* =========================
       CARREGAR DENTISTAS
    ========================= */
    function carregarDentistas() {

        axios
            .get('/teamOdonto/public/api.php?api=dentistas')
            .then(response => {

                const dentistas = response.data;
                tbody.innerHTML = '';

                if (!Array.isArray(dentistas) || dentistas.length === 0) {
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                Nenhum dentista encontrado.
                            </td>
                        </tr>
                    `;
                    return;
                }

                dentistas.forEach(d => {
                    const tr = document.createElement('tr');

                    tr.innerHTML = `
                        <td>${d.id}</td>

                        <td>${d.nome}</td>

                        <td>${d.cpf}</td>

                        <td>${d.telefone ?? '-'}</td>

                        <td class="fw-bold">${d.cro}</td>

                        <td>${d.especialidade ?? '-'}</td>

                        <!-- ✅ AÇÕES PADRONIZADAS -->
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">

                                <a href="/teamOdonto/public/index.php?page=dentista-view&id=${d.id}"
                                   class="btn btn-sm btn-outline-info"
                                   title="Visualizar">
                                    <i class="bi bi-eye"></i>
                                </a>

                                <a href="/teamOdonto/public/index.php?page=dentista-edit&id=${d.id}"
                                   class="btn btn-sm btn-outline-warning"
                                   title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <button class="btn btn-sm btn-outline-danger btn-excluir"
                                        data-id="${d.id}"
                                        title="Excluir">
                                    <i class="bi bi-trash"></i>
                                </button>

                            </div>
                        </td>
                    `;

                    tbody.appendChild(tr);
                });

                ativarExcluir();
            })
            .catch(error => {
                console.error(error);
                tbody.innerHTML = `
                    <tr>
                        <td colspan="7" class="text-center text-danger py-4">
                            Erro ao carregar dentistas.
                        </td>
                    </tr>
                `;
            });
    }

    /* =========================
       EXCLUIR DENTISTA
    ========================= */
    function ativarExcluir() {
        document.querySelectorAll('.btn-excluir').forEach(btn => {
            btn.addEventListener('click', () => {

                const id = btn.dataset.id;

                if (!confirm('Deseja realmente excluir este dentista?')) return;

                axios
                    .delete(`/teamOdonto/public/api.php?api=dentistas&id=${id}`)
                    .then(response => {
                        if (response.data.success) {
                            carregarDentistas();
                        } else {
                            alert('Erro ao excluir dentista.');
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
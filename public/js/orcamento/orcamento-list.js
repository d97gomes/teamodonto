document.addEventListener('DOMContentLoaded', () => {

    const tbody = document.querySelector('#tabelaOrcamentos tbody');

    /* =========================
       LISTAR ORÇAMENTOS
    ========================= */

    axios
        .get('/teamOdonto/public/api.php?api=orcamentos')
        .then(res => {

            const dados = res.data;
            tbody.innerHTML = '';

            if (!dados.length) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            Nenhum orçamento encontrado
                        </td>
                    </tr>
                `;
                return;
            }

            dados.forEach(o => {
                const tr = document.createElement('tr');

                tr.innerHTML = `
                    <td>${o.paciente}</td>

                    <td>${o.dentista}</td>

                    <td>
                        ${new Date(o.data_orcamento.replace(' ', 'T'))
                            .toLocaleDateString('pt-BR')}
                    </td>

                    <td class="fw-bold">
                        R$ ${Number(o.valor_total).toFixed(2).replace('.', ',')}
                    </td>

                    <td>
                        <span class="badge bg-${o.status === 'aprovado' ? 'success' : 'secondary'}">
                            ${o.status}
                        </span>
                    </td>

                    <!-- ✅ COLUNA AÇÕES AJUSTADA -->
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-2">

                            <a href="index.php?page=orcamento-view&id=${o.id}"
                               class="btn btn-sm btn-outline-info">
                                <i class="bi bi-eye"></i>
                            </a>

                            <a href="index.php?page=orcamento-edit&id=${o.id}"
                               class="btn btn-sm btn-outline-warning">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <button class="btn btn-sm btn-outline-danger"
                                    data-id="${o.id}">
                                <i class="bi bi-trash"></i>
                            </button>

                        </div>
                    </td>
                `;

                tbody.appendChild(tr);
            });
        })
        .catch(err => {
            console.error('Erro ao listar orçamentos:', err);
            tbody.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center text-danger py-4">
                        Erro ao carregar orçamentos
                    </td>
                </tr>
            `;
        });

    /* =========================
       EXCLUIR ORÇAMENTO
    ========================= */

    document.addEventListener('click', async e => {

        const btn = e.target.closest('.btn-outline-danger');
        if (!btn || !btn.dataset.id) return;

        const id = btn.dataset.id;

        if (!confirm('Deseja excluir este orçamento?')) return;

        try {
            const res = await axios.delete(
                `/teamOdonto/public/api.php?api=orcamentos&id=${id}`
            );

            if (res.data.success) {

                btn.closest('tr').remove();

            } else {
                alert(res.data.message || 'Erro ao excluir orçamento');
            }

        } catch (err) {
            console.error('Erro ao excluir orçamento:', err);
            alert('Erro ao excluir orçamento.');
        }
    });

});
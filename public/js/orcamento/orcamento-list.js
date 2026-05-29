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
                        <td colspan="6" class="text-center">
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
                    <td>${new Date(o.data_orcamento).toLocaleDateString()}</td>
                    <td>R$ ${Number(o.valor_total).toFixed(2).replace('.', ',')}</td>
                    <td>${o.status}</td>
                    <td>
                        <a href="index.php?page=orcamento-view&id=${o.id}"
                           class="btn btn-sm btn-info me-1">
                            Ver
                        </a>

                        <a href="index.php?page=orcamento-edit&id=${o.id}"
                           class="btn btn-sm btn-warning me-1">
                            Editar
                        </a>

                        <button class="btn btn-sm btn-danger"
                                data-id="${o.id}">
                            Excluir
                        </button>
                    </td>
                `;

                tbody.appendChild(tr);
            });
        })
        .catch(err => {
            console.error('Erro ao listar orçamentos:', err);
            tbody.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center text-danger">
                        Erro ao carregar orçamentos
                    </td>
                </tr>
            `;
        });

    /* =========================
       EXCLUIR ORÇAMENTO
    ========================= */

    document.addEventListener('click', async e => {

        const btn = e.target.closest('.btn-danger');
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
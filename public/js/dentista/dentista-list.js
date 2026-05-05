document.addEventListener('DOMContentLoaded', () => {

    const tbody = document.getElementById('listaDentistas');
    if (!tbody) return;

    carregarDentistas();

    async function carregarDentistas() {
        try {
            const response = await axios.get(
                '/teamOdonto/public/index.php?api=dentistas'
            );

            const dentistas = response.data;
            tbody.innerHTML = '';

            if (!Array.isArray(dentistas) || dentistas.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="7" class="text-center text-muted">
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
                    <td>${d.telefone ?? ''}</td>
                    <td>${d.cro}</td>
                    <td>${d.especialidade}</td>
                    <td class="text-center">
                        <a href="/teamOdonto/public/index.php?page=dentista-view&id=${d.id}"
                           class="btn btn-sm btn-info me-1">
                            Ver
                        </a>

                        <a href="/teamOdonto/public/index.php?page=dentista-edit&id=${d.id}"
                           class="btn btn-sm btn-warning me-1">
                            Editar
                        </a>

                        <button class="btn btn-sm btn-danger btn-excluir"
                                data-id="${d.id}">
                            Excluir
                        </button>
                    </td>
                `;

                tbody.appendChild(tr);
            });

            ativarExcluir();

        } catch (error) {
            console.error(error);
            tbody.innerHTML = `
                <tr>
                    <td colspan="7" class="text-center text-danger">
                        Erro ao carregar dentistas.
                    </td>
                </tr>
            `;
        }
    }

    function ativarExcluir() {
        document.querySelectorAll('.btn-excluir').forEach(btn => {
            btn.addEventListener('click', async () => {
                const id = btn.dataset.id;

                if (!confirm('Deseja realmente excluir este dentista?')) return;

                try {
                    const response = await axios.delete(
                        `/teamOdonto/public/index.php?api=dentistas&id=${id}`
                    );

                    if (response.data.success) {
                        carregarDentistas();
                    } else {
                        alert('Erro ao excluir dentista.');
                    }

                } catch (error) {
                    console.error(error);
                    alert('Erro de comunicação com o servidor.');
                }
            });
        });
    }
});

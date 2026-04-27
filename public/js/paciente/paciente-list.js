document.addEventListener('DOMContentLoaded', () => {

    const tbody = document.getElementById('listaPacientes');
    if (!tbody) return;

    carregarPacientes();

    async function carregarPacientes() {
        try {
            const response = await axios.get(
                '/teamOdonto/public/index.php?api=pacientes'
            );

            const pacientes = response.data;
            tbody.innerHTML = '';

            if (!Array.isArray(pacientes) || pacientes.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="5" class="text-center text-muted">
                            Nenhum paciente cadastrado
                        </td>
                    </tr>
                `;
                return;
            }

            pacientes.forEach(p => {
                const tr = document.createElement('tr');

                tr.innerHTML = `
                    <td>${p.id}</td>
                    <td>${p.nome}</td>
                    <td>${p.cpf}</td>
                    <td>${p.telefone ?? ''}</td>
                    <td>
                        <a href="/teamOdonto/public/index.php?page=paciente-view&id=${p.id}"
                           class="btn btn-sm btn-info mb-1">
                           Ver
                        </a>

                        <a href="/teamOdonto/public/index.php?page=paciente-edit&id=${p.id}"
                           class="btn btn-sm btn-warning mb-1">
                           Editar
                        </a>

                        <button class="btn btn-sm btn-danger btn-excluir"
                                data-id="${p.id}">
                            Excluir
                        </button>
                    </td>
                `;

                tbody.appendChild(tr);
            });

            ativarBotoesExcluir();

        } catch (error) {
            console.error(error);
            tbody.innerHTML = `
                <tr>
                    <td colspan="5" class="text-center text-danger">
                        Erro ao carregar pacientes
                    </td>
                </tr>
            `;
        }
    }

    function ativarBotoesExcluir() {
        document.querySelectorAll('.btn-excluir').forEach(btn => {
            btn.addEventListener('click', async () => {
                const id = btn.dataset.id;

                if (!confirm('Deseja realmente excluir este paciente?')) return;

                try {
                    const response = await axios.delete(
                        `/teamOdonto/public/index.php?api=pacientes&id=${id}`
                    );

                    if (response.data.success) {
                        carregarPacientes();
                    } else {
                        alert('Erro ao excluir paciente.');
                    }

                } catch (error) {
                    console.error(error);
                    alert('Erro de comunicação com o servidor.');
                }
            });
        });
    }
});
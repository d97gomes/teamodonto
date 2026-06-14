document.addEventListener('DOMContentLoaded', () => {

    const tbody = document.getElementById('listaPacientes');
    if (!tbody) return;

    carregarPacientes();

    /* =========================
       CARREGAR PACIENTES
    ========================= */
    function carregarPacientes() {

        axios
            .get('/teamOdonto/public/api.php?api=pacientes')
            .then(response => {

                const pacientes = response.data;
                tbody.innerHTML = '';

                if (!Array.isArray(pacientes) || pacientes.length === 0) {
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
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

                        <td>${p.telefone ?? '-'}</td>

                        <!-- ✅ AÇÕES PADRONIZADAS -->
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">

                                <a href="/teamOdonto/public/index.php?page=paciente-view&id=${p.id}"
                                   class="btn btn-sm btn-outline-info">
                                    <i class="bi bi-eye"></i>
                                </a>

                                <a href="/teamOdonto/public/index.php?page=paciente-edit&id=${p.id}"
                                   class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <button class="btn btn-sm btn-outline-danger btn-excluir"
                                        data-id="${p.id}">
                                    <i class="bi bi-trash"></i>
                                </button>

                            </div>
                        </td>
                    `;

                    tbody.appendChild(tr);
                });

                ativarBotoesExcluir();
            })
            .catch(error => {
                console.error(error);
                tbody.innerHTML = `
                    <tr>
                        <td colspan="5" class="text-center text-danger py-4">
                            Erro ao carregar pacientes
                        </td>
                    </tr>
                `;
            });
    }

    /* =========================
       EXCLUIR PACIENTE
    ========================= */
    function ativarBotoesExcluir() {
        document.querySelectorAll('.btn-excluir').forEach(btn => {
            btn.addEventListener('click', () => {

                const id = btn.dataset.id;

                if (!confirm('Deseja realmente excluir este paciente?')) return;

                axios
                    .delete(`/teamOdonto/public/api.php?api=pacientes&id=${id}`)
                    .then(response => {
                        if (response.data.success) {
                            carregarPacientes();
                        } else {
                            alert('Erro ao excluir paciente.');
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
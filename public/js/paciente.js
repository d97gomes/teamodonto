document.addEventListener('DOMContentLoaded', () => {

    /* ==========================
       READ – LISTAR PACIENTES
    ========================== */
    const tabela = document.getElementById('tabelaPacientes');

    if (tabela) {
        axios.get('/teamOdonto/app/api/pacienteApi.php?action=list')
            .then(response => {
                const pacientes = response.data;
                tabela.innerHTML = '';

                if (!pacientes.length) {
                    tabela.innerHTML = `
                        <tr>
                            <td colspan="5" class="text-center">
                                Nenhum paciente cadastrado
                            </td>
                        </tr>
                    `;
                    return;
                }

                pacientes.forEach(p => {
                    tabela.innerHTML += `
                        <tr>
                            <td>${p.id}</td>
                            <td>
                                <a href="pacienteView.php?id=${p.id}">
                                    ${p.nome}
                                </a>
                            </td>
                            <td>${p.cpf}</td>
                            <td>${p.telefone ?? ''}</td>
                            <td>
                                <a href="pacienteEdit.php?id=${p.id}" class="btn btn-sm btn-warning">
                                    Editar
                                </a>
                                <button class="btn btn-sm btn-danger"
                                    onclick="excluirPaciente(${p.id})">
                                    Excluir
                                </button>
                            </td>
                        </tr>
                    `;
                });
            })
            .catch(() => {
                alert('Erro ao carregar pacientes');
            });
    }

    /* ==========================
       CREATE – CADASTRAR
    ========================== */
    const formCreate = document.getElementById('formPaciente');

    if (formCreate) {
        formCreate.addEventListener('submit', e => {
            e.preventDefault();

            const dados = Object.fromEntries(new FormData(formCreate));

            axios.post(
                '/teamOdonto/app/api/pacienteApi.php?action=create',
                dados
            ).then(response => {
                if (response.data.success) {
                    alert('Paciente cadastrado com sucesso!');
                    window.location.href = 'pacienteList.php';
                } else {
                    alert('Erro ao cadastrar paciente');
                }
            });
        });
    }

    /* ==========================
       UPDATE – ATUALIZAR
    ========================== */
    const formEdit = document.getElementById('formPacienteEdit');

    if (formEdit) {
        formEdit.addEventListener('submit', e => {
            e.preventDefault();

            const dados = Object.fromEntries(new FormData(formEdit));

            axios.post(
                '/teamOdonto/app/api/pacienteApi.php?action=update',
                dados
            ).then(response => {
                if (response.data.success) {
                    alert('Paciente atualizado com sucesso!');
                    window.location.href = 'pacienteList.php';
                } else {
                    alert('Erro ao atualizar paciente');
                }
            });
        });
    }
});

/* ==========================
   DELETE – EXCLUIR
========================== */
function excluirPaciente(id) {
    if (!confirm('Deseja realmente excluir este paciente?')) return;

    axios.delete(
        `/teamOdonto/app/api/pacienteApi.php?action=delete&id=${id}`
    ).then(response => {
        if (response.data.success) {
            alert('Paciente excluído com sucesso');
            location.reload();
        } else {
            alert('Erro ao excluir paciente');
        }
    });
}
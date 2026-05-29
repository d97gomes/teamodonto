document.addEventListener('DOMContentLoaded', () => {

    const form = document.getElementById('formAnamnese');
    if (!form) return;

    // Inputs de busca
    const inputBuscarPaciente = document.getElementById('buscarPaciente');
    const inputBuscarDentista = document.getElementById('buscarDentista');

    // Campos hidden (IDs reais)
    const hiddenPacienteId = document.getElementById('paciente_id');
    const hiddenDentistaId = document.getElementById('dentista_id');

    // Listas de resultado
    const listaPacientes = document.getElementById('listaPacientes');
    const listaDentistas = document.getElementById('listaDentistas');

    /* =========================
       BUSCA DE PACIENTE
    ========================= */
    inputBuscarPaciente.addEventListener('input', () => {
        const termo = inputBuscarPaciente.value.trim();
        listaPacientes.innerHTML = '';
        hiddenPacienteId.value = '';

        if (termo.length < 3) return;

        axios
            .get(`/teamOdonto/public/api.php?api=pacientes&search=${encodeURIComponent(termo)}`)
            .then(res => {
                const pacientes = res.data;

                if (!Array.isArray(pacientes) || pacientes.length === 0) {
                    listaPacientes.innerHTML =
                        '<li class="list-group-item text-muted">Nenhum paciente encontrado</li>';
                    return;
                }

                pacientes.forEach(p => {
                    const li = document.createElement('li');
                    li.className = 'list-group-item list-group-item-action';
                    li.textContent = `${p.nome} (CPF: ${p.cpf})`;

                    li.addEventListener('click', () => {
                        hiddenPacienteId.value = p.id;
                        inputBuscarPaciente.value = p.nome;
                        listaPacientes.innerHTML = '';
                    });

                    listaPacientes.appendChild(li);
                });
            })
            .catch(() => {
                listaPacientes.innerHTML =
                    '<li class="list-group-item text-danger">Erro ao buscar pacientes</li>';
            });
    });

    /* =========================
       BUSCA DE DENTISTA
    ========================= */
    inputBuscarDentista.addEventListener('input', () => {
        const termo = inputBuscarDentista.value.trim();
        listaDentistas.innerHTML = '';
        hiddenDentistaId.value = '';

        if (termo.length < 3) return;

        axios
            .get(`/teamOdonto/public/api.php?api=dentistas&search=${encodeURIComponent(termo)}`)
            .then(res => {
                const dentistas = res.data;

                if (!Array.isArray(dentistas) || dentistas.length === 0) {
                    listaDentistas.innerHTML =
                        '<li class="list-group-item text-muted">Nenhum dentista encontrado</li>';
                    return;
                }

                dentistas.forEach(d => {
                    const li = document.createElement('li');
                    li.className = 'list-group-item list-group-item-action';
                    li.textContent = `${d.nome} (CRO: ${d.cro})`;

                    li.addEventListener('click', () => {
                        hiddenDentistaId.value = d.id;
                        inputBuscarDentista.value = d.nome;
                        listaDentistas.innerHTML = '';
                    });

                    listaDentistas.appendChild(li);
                });
            })
            .catch(() => {
                listaDentistas.innerHTML =
                    '<li class="list-group-item text-danger">Erro ao buscar dentistas</li>';
            });
    });

    /* =========================
       SUBMIT DA ANAMNESE
    ========================= */
    form.addEventListener('submit', e => {
        e.preventDefault();

        const dados = {
            paciente_id: hiddenPacienteId.value,
            dentista_id: hiddenDentistaId.value,

            diabetes: document.getElementById('diabetes').checked ? 1 : 0,
            hipertensao: document.getElementById('hipertensao').checked ? 1 : 0,
            problemas_cardiacos: document.getElementById('problemas_cardiacos').checked ? 1 : 0,
            problemas_respiratorios: document.getElementById('problemas_respiratorios').checked ? 1 : 0,

            alergias: document.getElementById('alergias').value.trim(),
            medicamentos_em_uso: document.getElementById('medicamentos_em_uso').value.trim(),
            observacoes: document.getElementById('observacoes').value.trim()
        };

        if (!dados.paciente_id || !dados.dentista_id) {
            alert('Selecione um paciente e um dentista.');
            return;
        }

        axios
            .post('/teamOdonto/public/api.php?api=anamneses', dados)
            .then(res => {
                if (res.data && res.data.success) {
                    alert('Anamnese salva com sucesso!');
                    window.location.href =
                        '/teamOdonto/public/index.php?page=anamnese-list';
                } else {
                    alert(res.data?.message || 'Erro ao salvar anamnese.');
                }
            })
            .catch(err => {
                if (err.response && err.response.status === 401) {
                    alert('Sessão expirada. Faça login novamente.');
                    window.location.href =
                        '/teamOdonto/public/index.php?page=login';
                    return;
                }

                alert('Erro de comunicação com o servidor.');
            });
    });

});
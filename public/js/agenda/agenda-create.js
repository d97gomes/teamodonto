document.addEventListener('DOMContentLoaded', () => {

    /* ===== BUSCA PACIENTE ===== */
    const buscaPaciente   = document.getElementById('buscaPaciente');
    const listaPacientes  = document.getElementById('listaPacientes');
    const pacienteId     = document.getElementById('paciente_id');

    // Sempre que digitar, invalida o ID
    buscaPaciente.addEventListener('input', () => {
        pacienteId.value = '';
    });

    buscaPaciente.addEventListener('keyup', () => {
        if (buscaPaciente.value.length < 2) {
            listaPacientes.classList.add('d-none');
            return;
        }

        axios.get('/teamOdonto/public/api.php', {
            params: {
                api: 'pacientes',
                search: buscaPaciente.value
            }
        }).then(res => {

            const dados = res.data.data ?? res.data ?? [];
            listaPacientes.innerHTML = '';
            listaPacientes.classList.remove('d-none');

            dados.forEach(p => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'list-group-item list-group-item-action';
                btn.textContent = p.nome;

                btn.addEventListener('click', () => {
                    buscaPaciente.value = p.nome;
                    pacienteId.value = p.id;
                    listaPacientes.classList.add('d-none');
                });

                listaPacientes.appendChild(btn);
            });
        });
    });

    /* ===== BUSCA DENTISTA ===== */
    const buscaDentista  = document.getElementById('buscaDentista');
    const listaDentistas = document.getElementById('listaDentistas');
    const dentistaId    = document.getElementById('dentista_id');

    // Sempre que digitar, invalida o ID
    buscaDentista.addEventListener('input', () => {
        dentistaId.value = '';
    });

    buscaDentista.addEventListener('keyup', () => {
        if (buscaDentista.value.length < 2) {
            listaDentistas.classList.add('d-none');
            return;
        }

        axios.get('/teamOdonto/public/api.php', {
            params: {
                api: 'dentistas',
                search: buscaDentista.value
            }
        }).then(res => {

            const dados = res.data.data ?? res.data ?? [];
            listaDentistas.innerHTML = '';
            listaDentistas.classList.remove('d-none');

            dados.forEach(d => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'list-group-item list-group-item-action';
                btn.textContent = d.nome;

                btn.addEventListener('click', () => {
                    buscaDentista.value = d.nome;
                    dentistaId.value = d.id;
                    listaDentistas.classList.add('d-none');
                });

                listaDentistas.appendChild(btn);
            });
        });
    });

    /* ===== SUBMIT (AJUSTADO DEFINITIVO) ===== */
    document.getElementById('agendaCreateForm').addEventListener('submit', e => {
        e.preventDefault();

        if (!pacienteId.value || !dentistaId.value) {
            alert('Selecione o paciente e o dentista na lista.');
            return;
        }

        const data = document.getElementById('data').value;
        const hora = document.getElementById('hora').value;

        if (!data || !hora) {
            alert('Selecione a data e a hora.');
            return;
        }

        const formData = new FormData();
        formData.append('paciente_id', pacienteId.value);
        formData.append('dentista_id', dentistaId.value);

        // ✅ NOMES EXATOS QUE O CONTROLLER ESPERA
        formData.append('data_agenda', data);
        formData.append('hora_agenda', hora);

        axios.post('/teamOdonto/public/api.php?api=agenda', formData)
            .then(res => {
                if (res.data.success) {
                    window.location.href = 'index.php?page=agenda';
                } else {
                    alert(res.data.message ?? 'Erro ao criar agendamento.');
                }
            })
            .catch(() => {
                alert('Erro de comunicação com o servidor.');
            });
    });

});
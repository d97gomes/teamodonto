document.addEventListener('DOMContentLoaded', () => {

    /* ===== BUSCA PACIENTE ===== */
    const buscaPaciente = document.getElementById('buscaPaciente');
    const listaPacientes = document.getElementById('listaPacientes');
    const pacienteId = document.getElementById('paciente_id');

    buscaPaciente.addEventListener('keyup', () => {
        if (buscaPaciente.value.length < 2) {
            listaPacientes.classList.add('d-none');
            return;
        }

        axios.get('/teamOdonto/public/api.php', {
            params: { api: 'pacientes', search: buscaPaciente.value }
        }).then(res => {

            const dados = res.data.data ?? res.data ?? [];
            listaPacientes.innerHTML = '';
            listaPacientes.classList.remove('d-none');

            dados.forEach(p => {
                listaPacientes.innerHTML += `
                    <button type="button" class="list-group-item list-group-item-action">
                        ${p.nome}
                    </button>
                `;
            });

            listaPacientes.querySelectorAll('button').forEach((btn, index) => {
                btn.addEventListener('click', () => {
                    buscaPaciente.value = dados[index].nome;
                    pacienteId.value = dados[index].id;
                    listaPacientes.classList.add('d-none');
                });
            });
        });
    });

    /* ===== BUSCA DENTISTA ===== */
    const buscaDentista = document.getElementById('buscaDentista');
    const listaDentistas = document.getElementById('listaDentistas');
    const dentistaId = document.getElementById('dentista_id');

    buscaDentista.addEventListener('keyup', () => {
        if (buscaDentista.value.length < 2) {
            listaDentistas.classList.add('d-none');
            return;
        }

        axios.get('/teamOdonto/public/api.php', {
            params: { api: 'dentistas', search: buscaDentista.value }
        }).then(res => {

            const dados = res.data.data ?? res.data ?? [];
            listaDentistas.innerHTML = '';
            listaDentistas.classList.remove('d-none');

            dados.forEach(d => {
                listaDentistas.innerHTML += `
                    <button type="button" class="list-group-item list-group-item-action">
                        ${d.nome}
                    </button>
                `;
            });

            listaDentistas.querySelectorAll('button').forEach((btn, index) => {
                btn.addEventListener('click', () => {
                    buscaDentista.value = dados[index].nome;
                    dentistaId.value = dados[index].id;
                    listaDentistas.classList.add('d-none');
                });
            });
        });
    });

    /* ===== SUBMIT ===== */
    document.getElementById('agendaCreateForm').addEventListener('submit', e => {
        e.preventDefault();

        if (!pacienteId.value || !dentistaId.value) {
            alert('Selecione o paciente e o dentista na lista.');
            return;
        }

        axios.post('/teamOdonto/public/api.php?api=agenda', {
            paciente_id: pacienteId.value,
            dentista_id: dentistaId.value,
            data: document.getElementById('data').value,
            hora: document.getElementById('hora').value
        }).then(res => {

            if (res.data.success) {
                window.location.href = 'index.php?page=agenda';
            } else {
                alert(res.data.message ?? 'Erro ao criar agendamento.');
            }

        }).catch(() => {
            alert('Erro de comunicação com o servidor.');
        });
    });

});
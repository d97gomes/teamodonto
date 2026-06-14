document.addEventListener('DOMContentLoaded', () => {

    const form = document.getElementById('agendaCreateForm');
    if (!form) return;

    const btnSubmit = form.querySelector('button[type="submit"]');

    /* ===== BUSCA PACIENTE ===== */
    const buscaPaciente   = document.getElementById('buscaPaciente');
    const listaPacientes  = document.getElementById('listaPacientes');
    const pacienteId      = document.getElementById('paciente_id');

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

        }).catch(() => {
            listaPacientes.innerHTML =
                '<li class="list-group-item text-danger">Erro ao buscar pacientes</li>';
        });
    });

    /* ===== BUSCA DENTISTA ===== */
    const buscaDentista  = document.getElementById('buscaDentista');
    const listaDentistas = document.getElementById('listaDentistas');
    const dentistaId     = document.getElementById('dentista_id');

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

        }).catch(() => {
            listaDentistas.innerHTML =
                '<li class="list-group-item text-danger">Erro ao buscar dentistas</li>';
        });
    });

    /* ===== SUBMIT ===== */
    form.addEventListener('submit', e => {
        e.preventDefault();

        if (!pacienteId.value || !dentistaId.value) {
            mostrarMensagem('Selecione o paciente e o dentista ❌', 'danger');
            return;
        }

        const data = document.getElementById('data').value;
        const hora = document.getElementById('hora').value;

        if (!data || !hora) {
            mostrarMensagem('Selecione a data e a hora ❌', 'danger');
            return;
        }

        /* ===== LOADING ===== */
        btnSubmit.disabled = true;
        btnSubmit.innerHTML = `
            <span class="spinner-border spinner-border-sm me-1"></span>
            Salvando...
        `;

        const formData = new FormData();
        formData.append('paciente_id', pacienteId.value);
        formData.append('dentista_id', dentistaId.value);
        formData.append('data_agenda', data);
        formData.append('hora_agenda', hora);

        axios.post('/teamOdonto/public/api.php?api=agenda', formData)
            .then(res => {

                if (res.data.success) {

                    mostrarMensagem('Agendamento criado com sucesso ✅', 'success');

                    setTimeout(() => {
                        window.location.href = 'index.php?page=agenda';
                    }, 1200);

                } else {
                    mostrarMensagem(res.data.message ?? 'Erro ao criar agendamento ❌', 'danger');
                }

            })
            .catch(() => {
                mostrarMensagem('Erro de comunicação com o servidor ❌', 'danger');
            })
            .finally(() => {

                btnSubmit.disabled = false;
                btnSubmit.innerHTML = 'Salvar';

            });
    });

});

/* =========================
   ALERTA PADRÃO 🔥
========================= */
function mostrarMensagem(texto, tipo = 'success') {

    let alerta = document.getElementById('alertaSistema');

    if (!alerta) {
        alerta = document.createElement('div');
        alerta.id = 'alertaSistema';
        alerta.className = `alert alert-${tipo} mt-3`;

        document.querySelector('.main-content')?.prepend(alerta);
    }

    alerta.className = `alert alert-${tipo} mt-3`;
    alerta.innerHTML = texto;

    setTimeout(() => {
        alerta.remove();
    }, 3000);
}
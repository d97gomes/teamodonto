document.addEventListener('DOMContentLoaded', () => {

    const form = document.getElementById('formAnamnese');
    if (!form) return;

    const btnSubmit = form.querySelector('button[type="submit"]');

    const inputBuscarPaciente = document.getElementById('buscarPaciente');
    const inputBuscarDentista = document.getElementById('buscarDentista');

    const hiddenPacienteId = document.getElementById('paciente_id');
    const hiddenDentistaId = document.getElementById('dentista_id');

    const listaPacientes = document.getElementById('listaPacientes');
    const listaDentistas = document.getElementById('listaDentistas');

    /* =========================
       BUSCA PACIENTE
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

                    li.onclick = () => {
                        hiddenPacienteId.value = p.id;
                        inputBuscarPaciente.value = p.nome;
                        listaPacientes.innerHTML = '';
                    };

                    listaPacientes.appendChild(li);
                });

            })
            .catch(() => {
                listaPacientes.innerHTML =
                    '<li class="list-group-item text-danger">Erro ao buscar pacientes</li>';
            });
    });

    /* =========================
       BUSCA DENTISTA
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

                    li.onclick = () => {
                        hiddenDentistaId.value = d.id;
                        inputBuscarDentista.value = d.nome;
                        listaDentistas.innerHTML = '';
                    };

                    listaDentistas.appendChild(li);
                });

            })
            .catch(() => {
                listaDentistas.innerHTML =
                    '<li class="list-group-item text-danger">Erro ao buscar dentistas</li>';
            });
    });

    /* =========================
       SUBMIT ANAMNESE
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
            mostrarMensagem('Selecione paciente e dentista ❌', 'danger');
            return;
        }

        /* ===== LOADING ===== */
        btnSubmit.disabled = true;
        btnSubmit.innerHTML = `
            <span class="spinner-border spinner-border-sm me-1"></span>
            Salvando...
        `;

        axios
            .post('/teamOdonto/public/api.php?api=anamneses', dados)
            .then(res => {

                if (res.data && res.data.success) {

                    mostrarMensagem('Anamnese salva com sucesso ✅', 'success');

                    setTimeout(() => {
                        window.location.href =
                            '/teamOdonto/public/index.php?page=anamnese-list';
                    }, 1200);

                } else {
                    mostrarMensagem(res.data?.message || 'Erro ao salvar anamnese ❌', 'danger');
                }

            })
            .catch(err => {

                if (err.response && err.response.status === 401) {
                    mostrarMensagem('Sessão expirada. Faça login novamente ❌', 'danger');

                    setTimeout(() => {
                        window.location.href =
                            '/teamOdonto/public/index.php?page=login';
                    }, 1500);
                    return;
                }

                console.error(err);
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
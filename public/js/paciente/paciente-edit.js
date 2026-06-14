document.addEventListener('DOMContentLoaded', () => {

    const form = document.getElementById('formPaciente');
    if (!form) return;

    const btnSubmit = form.querySelector('button[type="submit"]');

    const params = new URLSearchParams(window.location.search);
    const id = params.get('id');

    if (!id) {
        mostrarMensagem('Paciente não informado ❌', 'danger');
        return;
    }

    /* =========================
       CARREGAR PACIENTE
    ========================= */
    axios
        .get(`/teamOdonto/public/api.php?api=pacientes&id=${id}`)
        .then(response => {

            const p = response.data;

            if (!p) {
                mostrarMensagem('Paciente não encontrado ❌', 'danger');
                return;
            }

            document.querySelector('[name="nome"]').value = p.nome ?? '';
            document.querySelector('[name="cpf"]').value = p.cpf ?? '';
            document.querySelector('[name="telefone"]').value = p.telefone ?? '';
            document.querySelector('[name="email"]').value = p.email ?? '';
            document.querySelector('[name="data_nascimento"]').value =
                p.data_nascimento ?? '';

            document.querySelector('[name="cep"]').value = p.cep ?? '';
            document.querySelector('[name="logradouro"]').value = p.logradouro ?? '';
            document.querySelector('[name="numero"]').value = p.numero ?? '';
            document.querySelector('[name="complemento"]').value = p.complemento ?? '';
            document.querySelector('[name="bairro"]').value = p.bairro ?? '';
            document.querySelector('[name="cidade"]').value = p.cidade ?? '';
            document.querySelector('[name="estado"]').value = p.estado ?? '';

        })
        .catch(error => {
            console.error(error);
            mostrarMensagem('Erro ao carregar paciente ❌', 'danger');
        });

    /* =========================
       SUBMIT (UPDATE)
    ========================= */
    form.addEventListener('submit', e => {
        e.preventDefault();

        const dados = Object.fromEntries(
            new FormData(form)
        );

        /* ===== LOADING ===== */
        btnSubmit.disabled = true;
        btnSubmit.innerHTML = `
            <span class="spinner-border spinner-border-sm me-1"></span>
            Salvando...
        `;

        axios
            .put(`/teamOdonto/public/api.php?api=pacientes&id=${id}`, dados)
            .then(response => {

                if (response.data.success) {

                    mostrarMensagem('Paciente atualizado com sucesso ✅', 'success');

                    setTimeout(() => {
                        window.location.href =
                            '/teamOdonto/public/index.php?page=paciente-list';
                    }, 1200);

                } else {
                    mostrarMensagem('Erro ao atualizar paciente ❌', 'danger');
                }

            })
            .catch(error => {
                console.error(error);
                mostrarMensagem('Erro de comunicação com o servidor ❌', 'danger');
            })
            .finally(() => {

                btnSubmit.disabled = false;
                btnSubmit.innerHTML = 'Salvar';

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

            form.prepend(alerta);
        }

        alerta.className = `alert alert-${tipo} mt-3`;
        alerta.innerHTML = texto;

        setTimeout(() => {
            alerta.remove();
        }, 3000);
    }

});
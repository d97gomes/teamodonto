document.addEventListener('DOMContentLoaded', () => {

    const form = document.getElementById('formDentista'); // ✅ CORRETO
    if (!form) return;

    const btnSubmit = form.querySelector('button[type="submit"]');

    const params = new URLSearchParams(window.location.search);
    const id = params.get('id');

    if (!id) {
        mostrarMensagem('Dentista não informado ❌', 'danger');
        return;
    }

    /* =========================
       CARREGAR DENTISTA ✅
    ========================= */
    axios
        .get(`/teamOdonto/public/api.php?api=dentistas&id=${id}`) // ✅ CORRIGIDO
        .then(response => {

            const d = response.data;

            if (!d) {
                mostrarMensagem('Dentista não encontrado ❌', 'danger');
                return;
            }

            // ✅ preencher campos
            document.querySelector('[name="nome"]').value = d.nome ?? '';
            document.querySelector('[name="cpf"]').value = d.cpf ?? '';
            document.querySelector('[name="sexo"]').value = d.sexo ?? '';
            document.querySelector('[name="telefone"]').value = d.telefone ?? '';
            document.querySelector('[name="email"]').value = d.email ?? '';

            document.querySelector('[name="cro"]').value = d.cro ?? '';
            document.querySelector('[name="especialidade"]').value = d.especialidade ?? '';

            document.querySelector('[name="cep"]').value = d.cep ?? '';
            document.querySelector('[name="logradouro"]').value = d.logradouro ?? '';
            document.querySelector('[name="numero"]').value = d.numero ?? '';
            document.querySelector('[name="complemento"]').value = d.complemento ?? '';
            document.querySelector('[name="bairro"]').value = d.bairro ?? '';
            document.querySelector('[name="cidade"]').value = d.cidade ?? '';
            document.querySelector('[name="estado"]').value = d.estado ?? '';

        })
        .catch(error => {
            console.error(error);
            mostrarMensagem('Erro ao carregar dentista ❌', 'danger');
        });

    /* =========================
       SUBMIT (UPDATE)
    ========================= */
    form.addEventListener('submit', e => {
        e.preventDefault();

        const dados = Object.fromEntries(
            new FormData(form)
        );

        console.log('DADOS ENVIADOS:', dados); // ✅ DEBUG

        /* ===== LOADING ===== */
        btnSubmit.disabled = true;
        btnSubmit.innerHTML = `
            <span class="spinner-border spinner-border-sm me-1"></span>
            Salvando...
        `;

        axios
            .put(`/teamOdonto/public/api.php?api=dentistas&id=${id}`, dados) // ✅ CORRIGIDO
            .then(response => {

                if (response.data.success) {

                    mostrarMensagem('Dentista atualizado com sucesso ✅', 'success');

                    setTimeout(() => {
                        window.location.href =
                            '/teamOdonto/public/index.php?page=dentista-list';
                    }, 1200);

                } else {
                    mostrarMensagem('Erro ao atualizar dentista ❌', 'danger');
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
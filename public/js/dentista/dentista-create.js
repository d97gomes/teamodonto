document.addEventListener('DOMContentLoaded', () => {

    const form = document.getElementById('formDentista'); // ✅ CORRETO
    if (!form) return;

    const btnSubmit = form.querySelector('button[type="submit"]');

    form.addEventListener('submit', e => {
        e.preventDefault();

        const dados = Object.fromEntries(
            new FormData(form)
        );

        console.log('DADOS ENVIADOS:', dados); // ✅ DEBUG

        /* =========================
           LOADING BOTÃO
        ========================= */
        btnSubmit.disabled = true;
        btnSubmit.innerHTML = `
            <span class="spinner-border spinner-border-sm me-1"></span>
            Salvando...
        `;

        axios
            .post('/teamOdonto/public/api.php?api=dentistas', dados) // ✅ CORRETO
            .then(response => {

                console.log('RESPOSTA:', response.data);

                if (response.data.success) {

                    mostrarMensagem('Dentista cadastrado com sucesso ✅', 'success');

                    setTimeout(() => {
                        window.location.href =
                            '/teamOdonto/public/index.php?page=dentista-list';
                    }, 1200);

                } else {
                    mostrarMensagem(
                        response.data.message || 'Erro ao cadastrar dentista ❌',
                        'danger'
                    );
                }

            })
            .catch(error => {
                console.error(error);
                mostrarMensagem('Erro de comunicação com o servidor ❌', 'danger');
            })
            .finally(() => {

                btnSubmit.disabled = false;
                btnSubmit.innerHTML = 'Salvar Dentista';

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
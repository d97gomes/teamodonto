document.addEventListener('DOMContentLoaded', () => {

    const form = document.getElementById('formDentista');
    if (!form) return;

    const btnSubmit = form.querySelector('button[type="submit"]');

    form.addEventListener('submit', e => {
        e.preventDefault();

        // Coleta dados
        const dados = Object.fromEntries(
            new FormData(form)
        );

        /* =========================
           LOADING BOTÃO
        ========================= */
        btnSubmit.disabled = true;
        btnSubmit.innerHTML = `
            <span class="spinner-border spinner-border-sm me-1"></span>
            Salvando...
        `;

        axios
            .post('/teamOdonto/public/api.php?api=dentistas', dados)
            .then(response => {

                const result = response.data;

                if (result.success) {

                    mostrarMensagem('Dentista cadastrado com sucesso ✅', 'success');

                    setTimeout(() => {
                        window.location.href =
                            '/teamOdonto/public/index.php?page=dentista-list';
                    }, 1200);

                } else {
                    mostrarMensagem(result.message || 'Erro ao cadastrar dentista ❌', 'danger');
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
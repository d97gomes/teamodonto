document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('formLogin');

    if (!form) {
        console.error('Formulário de login não encontrado');
        return;
    }

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(form);
        const msg = document.getElementById('mensagem');

        axios.post('/teamOdonto/public/auth/login', formData)
            .then(response => {
                const data = response.data;

                if (data.success) {
                    msg.className = 'alert alert-success';
                    msg.innerText = data.message;

                    setTimeout(() => {
                        window.location.href = '/teamOdonto/public/home';
                    }, 1000);
                } else {
                    msg.className = 'alert alert-danger';
                    msg.innerText = data.message;
                }

                msg.classList.remove('d-none');
            })
            .catch(error => {
                console.error('Erro no login:', error);
                msg.className = 'alert alert-danger';
                msg.innerText = 'Erro ao processar login.';
                msg.classList.remove('d-none');
            });
    });

});
``
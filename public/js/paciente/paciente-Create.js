document.addEventListener('DOMContentLoaded', () => {

    const form = document.getElementById('formPaciente');
    if (!form) return;

    form.addEventListener('submit', e => {
        e.preventDefault();

        const dados = Object.fromEntries(
            new FormData(form)
        );

        axios
            .post('/teamOdonto/public/api.php?api=pacientes', dados)
            .then(response => {

                if (response.data.success) {
                    alert('Paciente cadastrado com sucesso!');
                    window.location.href =
                        '/teamOdonto/public/index.php?page=paciente-list';
                } else {
                    alert('Erro ao cadastrar paciente.');
                }
            })
            .catch(error => {
                console.error(error);
                alert('Erro de comunicação com o servidor.');
            });
    });

});
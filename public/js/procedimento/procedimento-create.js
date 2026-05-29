document.addEventListener('DOMContentLoaded', () => {

    const form = document.getElementById('formProcedimento');
    if (!form) return;

    form.addEventListener('submit', e => {
        e.preventDefault();

        const dados = Object.fromEntries(
            new FormData(form)
        );

        axios
            .post('/teamOdonto/public/api.php?api=procedimentos', dados)
            .then(response => {

                const result = response.data;

                if (result.success) {
                    alert('Procedimento cadastrado com sucesso!');
                    window.location.href =
                        '/teamOdonto/public/index.php?page=procedimento-list';
                } else {
                    alert(result.message || 'Erro ao cadastrar.');
                }
            })
            .catch(error => {
                console.error(error);
                alert('Erro de comunicação com o servidor.');
            });
    });

});

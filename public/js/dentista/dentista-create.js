document.addEventListener('DOMContentLoaded', () => {

    const form = document.getElementById('formDentista');
    if (!form) return;

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        // Coleta os dados do formulário
        const dados = Object.fromEntries(
            new FormData(form)
        );

        try {
            const response = await fetch(
                '/teamOdonto/public/index.php?api=dentistas',
                {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(dados)
                }
            );

            const result = await response.json();

            if (result.success) {
                alert('Dentista cadastrado com sucesso!');
                window.location.href =
                    '/teamOdonto/public/index.php?page=dentista-list';
            } else {
                alert(result.message || 'Erro ao cadastrar dentista.');
            }

        } catch (error) {
            console.error(error);
            alert('Erro de comunicação com o servidor.');
        }
    });

});

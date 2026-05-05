document.addEventListener('DOMContentLoaded', () => {

    const form = document.getElementById('formDentista');
    if (!form) return;

    // ID do dentista vem pela URL (?page=dentista-edit&id=XX)
    const params = new URLSearchParams(window.location.search);
    const id = params.get('id');

    if (!id) {
        alert('ID do dentista não informado.');
        return;
    }

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const dados = Object.fromEntries(
            new FormData(form)
        );

        try {
            const response = await fetch(
                `/teamOdonto/public/index.php?api=dentistas&id=${id}`,
                {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(dados)
                }
            );

            const result = await response.json();

            if (result.success) {
                alert('Dentista atualizado com sucesso!');
                window.location.href =
                    '/teamOdonto/public/index.php?page=dentista-list';
            } else {
                alert(result.message || 'Erro ao atualizar dentista.');
            }

        } catch (error) {
            console.error(error);
            alert('Erro de comunicação com o servidor.');
        }
    });

});
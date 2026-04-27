document.addEventListener('DOMContentLoaded', () => {

    const form = document.getElementById('formPaciente');
    if (!form) return;

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const dados = Object.fromEntries(new FormData(form));

        try {
            // ✅ ENDPOINT SIMPLES E FUNCIONAL (API)
            const response = await axios.post(
                '/teamOdonto/public/index.php?api=pacientes',
                dados
            );

            if (response.data.success) {
                alert('Paciente cadastrado com sucesso!');
                // ✅ VOLTA PARA LISTAGEM (VIEW)
                window.location.href =
                    '/teamOdonto/public/index.php?page=paciente-list';
            } else {
                alert('Erro ao cadastrar paciente.');
            }

        } catch (error) {
            console.error(error);
            alert('Erro de comunicação com o servidor.');
        }
    });

});
``
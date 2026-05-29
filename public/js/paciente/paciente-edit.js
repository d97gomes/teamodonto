document.addEventListener('DOMContentLoaded', () => {

    const form = document.getElementById('formPaciente');
    if (!form) return;

    const params = new URLSearchParams(window.location.search);
    const id = params.get('id');

    if (!id) {
        alert('Paciente não informado.');
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
                alert('Paciente não encontrado.');
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
            alert('Erro ao carregar paciente.');
        });

    /* =========================
       SUBMIT (UPDATE)
    ========================= */
    form.addEventListener('submit', e => {
        e.preventDefault();

        const dados = Object.fromEntries(
            new FormData(form)
        );

        axios
            .put(`/teamOdonto/public/api.php?api=pacientes&id=${id}`, dados)
            .then(response => {

                if (response.data.success) {
                    alert('Paciente atualizado com sucesso!');
                    window.location.href =
                        '/teamOdonto/public/index.php?page=paciente-list';
                } else {
                    alert('Erro ao atualizar paciente.');
                }
            })
            .catch(error => {
                console.error(error);
                alert('Erro de comunicação com o servidor.');
            });
    });

});
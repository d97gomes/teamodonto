document.addEventListener('DOMContentLoaded', () => {

    const params = new URLSearchParams(window.location.search);
    const id = params.get('id');

    if (!id) {
        alert('Dentista não informado.');
        return;
    }

    carregarDentista(id);
});

async function carregarDentista(id) {
    try {
        const response = await axios.get(
            `/teamOdonto/public/index.php?api=dentistas&id=${id}`
        );

        const d = response.data;
        console.log('DADOS DO DENTISTA:', d);

        if (!d) {
            alert('Dentista não encontrado.');
            return;
        }

        // TÍTULO
        document.getElementById('dentista-nome-titulo').innerText =
            d.nome ?? '';

        // DADOS PESSOAIS
        document.getElementById('dentista-nome').innerText =
            d.nome ?? '';

        document.getElementById('dentista-cpf').innerText =
            d.cpf ?? '';

        document.getElementById('dentista-telefone').innerText =
            d.telefone ?? '';

        document.getElementById('dentista-email').innerText =
            d.email ?? '';

        document.getElementById('dentista-sexo').innerText =
            d.sexo ?? '';

        // DADOS PROFISSIONAIS
        document.getElementById('dentista-cro').innerText =
            d.cro ?? '';

        document.getElementById('dentista-especialidade').innerText =
            d.especialidade ?? '';

        // ENDEREÇO (VINDO DO JOIN)
        document.getElementById('endereco-logradouro').innerText =
            d.logradouro ?? '';

        document.getElementById('endereco-numero').innerText =
            d.numero ?? '';

        document.getElementById('endereco-bairro').innerText =
            d.bairro ?? '';

        document.getElementById('endereco-cidade').innerText =
            d.cidade ?? '';

        document.getElementById('endereco-estado').innerText =
            d.estado ?? '';

        document.getElementById('endereco-cep').innerText =
            d.cep ?? '';

    } catch (error) {
        console.error(error);
        alert('Erro ao carregar dados do dentista.');
    }
}

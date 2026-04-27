document.addEventListener('DOMContentLoaded', () => {

    const params = new URLSearchParams(window.location.search);
    const id = params.get('id');

    if (!id) {
        alert('Paciente não informado.');
        return;
    }

    carregarPaciente(id);

});

async function carregarPaciente(id) {
    try {
        const response = await axios.get(
            `/teamOdonto/public/index.php?api=pacientes&id=${id}`
        );

        const p = response.data;
        if (!p) {
            alert('Paciente não encontrado.');
            return;
        }

        // Dados pessoais
        document.getElementById('paciente-nome').innerText = p.nome ?? '';
        document.getElementById('paciente-cpf').innerText = p.cpf ?? '';
        document.getElementById('paciente-telefone').innerText = p.telefone ?? '';
        document.getElementById('paciente-email').innerText = p.email ?? '';
        document.getElementById('paciente-data-nascimento').innerText =
            p.data_nascimento ?? '';

        // Endereço
        document.getElementById('endereco-logradouro').innerText = p.logradouro ?? '';
        document.getElementById('endereco-numero').innerText = p.numero ?? '';
        document.getElementById('endereco-bairro').innerText = p.bairro ?? '';
        document.getElementById('endereco-cidade').innerText = p.cidade ?? '';
        document.getElementById('endereco-estado').innerText = p.estado ?? '';
        document.getElementById('endereco-cep').innerText = p.cep ?? '';

    } catch (error) {
        console.error(error);
        alert('Erro ao carregar dados do paciente.');
    }
}

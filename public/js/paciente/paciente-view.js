document.addEventListener('DOMContentLoaded', () => {

    const params = new URLSearchParams(window.location.search);
    const id = params.get('id');

    if (!id) {
        mostrarMensagem('Paciente não informado ❌', 'danger');
        return;
    }

    carregarPaciente(id);
});

/* =========================
   CARREGAR PACIENTE
========================= */
function carregarPaciente(id) {

    axios
        .get(`/teamOdonto/public/api.php?api=pacientes&id=${id}`)
        .then(response => {

            const p = response.data;

            if (!p) {
                mostrarMensagem('Paciente não encontrado ❌', 'danger');
                return;
            }

            /* ===== DADOS PESSOAIS ===== */
            document.getElementById('paciente-nome').innerText = p.nome ?? '-';
            document.getElementById('paciente-cpf').innerText = p.cpf ?? '-';
            document.getElementById('paciente-telefone').innerText = p.telefone ?? '-';
            document.getElementById('paciente-email').innerText = p.email ?? '-';
            document.getElementById('paciente-data-nascimento').innerText =
                p.data_nascimento ?? '-';

            /* ===== ENDEREÇO ===== */
            document.getElementById('endereco-logradouro').innerText =
                p.logradouro ?? '-';

            document.getElementById('endereco-numero').innerText =
                p.numero ?? '-';

            document.getElementById('endereco-bairro').innerText =
                p.bairro ?? '-';

            document.getElementById('endereco-cidade').innerText =
                p.cidade ?? '-';

            document.getElementById('endereco-estado').innerText =
                p.estado ?? '-';

            document.getElementById('endereco-cep').innerText =
                p.cep ?? '-';

        })
        .catch(error => {
            console.error(error);
            mostrarMensagem('Erro ao carregar dados do paciente ❌', 'danger');
        });
}

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
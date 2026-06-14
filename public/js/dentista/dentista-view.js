document.addEventListener('DOMContentLoaded', () => {

    const params = new URLSearchParams(window.location.search);
    const id = params.get('id');

    if (!id) {
        mostrarMensagem('Dentista não informado ❌', 'danger');
        return;
    }

    carregarDentista(id);
});

/* =========================
   CARREGAR DENTISTA
========================= */
function carregarDentista(id) {

    axios
        .get(`/teamOdonto/public/api.php?api=dentistas&id=${id}`)
        .then(response => {

            const d = response.data;

            if (!d) {
                mostrarMensagem('Dentista não encontrado ❌', 'danger');
                return;
            }

            /* ===== TÍTULO ===== */
            document.getElementById('dentista-nome-titulo').innerText =
                d.nome ?? '-';

            /* ===== DADOS PESSOAIS ===== */
            document.getElementById('dentista-nome').innerText =
                d.nome ?? '-';

            document.getElementById('dentista-cpf').innerText =
                d.cpf ?? '-';

            document.getElementById('dentista-telefone').innerText =
                d.telefone ?? '-';

            document.getElementById('dentista-email').innerText =
                d.email ?? '-';

            document.getElementById('dentista-sexo').innerText =
                d.sexo ?? '-';

            /* ===== DADOS PROFISSIONAIS ===== */
            document.getElementById('dentista-cro').innerText =
                d.cro ?? '-';

            document.getElementById('dentista-especialidade').innerText =
                d.especialidade ?? '-';

            /* ===== ENDEREÇO ===== */
            document.getElementById('endereco-logradouro').innerText =
                d.logradouro ?? '-';

            document.getElementById('endereco-numero').innerText =
                d.numero ?? '-';

            document.getElementById('endereco-bairro').innerText =
                d.bairro ?? '-';

            document.getElementById('endereco-cidade').innerText =
                d.cidade ?? '-';

            document.getElementById('endereco-estado').innerText =
                d.estado ?? '-';

            document.getElementById('endereco-cep').innerText =
                d.cep ?? '-';

        })
        .catch(error => {
            console.error(error);
            mostrarMensagem('Erro ao carregar dados do dentista ❌', 'danger');
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
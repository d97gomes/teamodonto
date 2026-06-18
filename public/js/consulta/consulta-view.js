document.addEventListener('DOMContentLoaded', () => {

    const main = document.querySelector('[data-id]'); // ✅ corrigido
    if (!main) {
        console.error('Elemento com data-id não encontrado');
        return;
    }

    const id = main.dataset.id;

    console.log('ID recebido:', id);

    if (!id) {
        mostrarMensagem('Consulta não informada ❌', 'danger');
        return;
    }
    /* =========================
       CARREGAR CONSULTA ✅
    ========================= */
    axios
        .get(`/teamOdonto/public/api.php?api=consultas&id=${id}`) // ✅ CORRIGIDO
        .then(res => {

            const c = res.data;

            console.log('CONSULTA VIEW:', c);

            if (!c) {
                mostrarMensagem('Consulta não encontrada ❌', 'danger');
                return;
            }

            /* PACIENTE */
            document.getElementById('consultaPaciente').textContent =
                c.paciente ?? '-';

            /* DENTISTA */
            document.getElementById('consultaDentista').textContent =
                c.dentista ?? '-';

            /* DATA */
            document.getElementById('consultaData').textContent =
                formatarData(c.data_inicio);

            /* STATUS */
            document.getElementById('consultaStatus').innerHTML =
                getBadgeStatus(c.status);

            /* EVOLUÇÃO */
            document.getElementById('consultaEvolucao').textContent =
                c.evolucao ?? 'Sem registro';

        })
        .catch(err => {
            console.error(err);
            mostrarMensagem('Erro ao carregar consulta ❌', 'danger');
        });

});


/* =========================
   FORMATAR DATA ✅
========================= */
function formatarData(data) {
    if (!data) return '-';

    const d = new Date(data.replace(' ', 'T'));
    return d.toLocaleString('pt-BR');
}


/* =========================
   STATUS COM COR ✅
========================= */
function getBadgeStatus(status) {

    const mapa = {
        pendente: 'secondary',
        em_atendimento: 'warning',
        finalizada: 'success',
        cancelado: 'danger'
    };

    const classe = mapa[status?.toLowerCase()] || 'secondary';

    return `
        <span class="badge bg-${classe}">
            ${formatarStatus(status)}
        </span>
    `;
}


/* =========================
   FORMATAR TEXTO
========================= */
function formatarStatus(status) {

    const mapa = {
        pendente: 'Pendente',
        em_atendimento: 'Em Atendimento',
        finalizada: 'Finalizada',
        cancelado: 'Cancelado'
    };

    return mapa[status?.toLowerCase()] || status;
}


/* =========================
   ALERTA PADRÃO ✅
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

    setTimeout(() => alerta.remove(), 3000);
}
document.addEventListener('DOMContentLoaded', () => {

    if (!ORCAMENTO_ID) {
        mostrarMensagem('Orçamento não informado ❌', 'danger');
        return;
    }

    /* =========================
       DADOS DO ORÇAMENTO ✅
    ========================= */
    axios
        .get(`/teamOdonto/public/api.php?api=orcamentos&id=${ORCAMENTO_ID}`)
        .then(res => {

            const o = res.data;

            console.log('ORCAMENTO VIEW:', o);

            document.getElementById('orcPaciente').textContent = o.paciente ?? '-';
            document.getElementById('orcDentista').textContent = o.dentista ?? '-';

                    /* ✅ DATA CORRETA (DO BANCO) */
            const dataEl = document.getElementById('orcData');

            if (dataEl && o.data_orcamento) {

                const data = new Date(o.data_orcamento.replace(' ', 'T'));

                dataEl.textContent = data.toLocaleDateString('pt-BR');

            } else {

                dataEl.textContent = '-';

            }

            /* ✅ STATUS CORRIGIDO */
            const statusEl = document.getElementById('orcStatus');

            if (statusEl && o.status) {
                statusEl.textContent = formatarStatus(o.status);
            } else {
                statusEl.textContent = '-';
            }

            document.getElementById('orcTotal').textContent =
                'R$ ' + Number(o.valor_total ?? 0).toFixed(2).replace('.', ',');

        })
        .catch(err => {
            console.error(err);
            mostrarMensagem('Erro ao carregar dados do orçamento ❌', 'danger');
        });


    /* =========================
       ITENS ✅
    ========================= */
    axios
        .get(`/teamOdonto/public/api.php?api=orcamento-itens&orcamento_id=${ORCAMENTO_ID}`)
        .then(res => {

            const tbody = document.getElementById('tabelaItens');
            tbody.innerHTML = '';

            if (res.data.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">
                            Nenhum item encontrado
                        </td>
                    </tr>`;
                return;
            }

            res.data.forEach(i => {

                const tr = document.createElement('tr');

                tr.innerHTML = `
                    <td class="text-center">${i.dente}</td>
                    <td class="text-center">${i.face}</td>
                    <td>${i.procedimento}</td>
                    <td class="fw-bold">
                        R$ ${Number(i.valor).toFixed(2).replace('.', ',')}
                    </td>`;

                tbody.appendChild(tr);
            });

        })
        .catch(err => {
            console.error(err);
            mostrarMensagem('Erro ao carregar itens do orçamento ❌', 'danger');
        });

});


/* =========================
   FORMATAR STATUS ✅
========================= */
function formatarStatus(status) {

    if (!status) return '-';

    const mapa = {
        aberto: 'Aberto',
        aprovado: 'Aprovado',
        reprovado: 'Reprovado'
    };

    return mapa[status.toLowerCase()] || status;
}


/* =========================
   ALERTA ✅
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
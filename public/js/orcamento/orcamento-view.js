document.addEventListener('DOMContentLoaded', () => {

    if (!ORCAMENTO_ID) return;

    /* =========================
       DADOS DO ORÇAMENTO
    ========================= */

    axios
        .get(`/teamOdonto/public/api.php?api=orcamentos&id=${ORCAMENTO_ID}`)
        .then(res => {
            const o = res.data;

            document.getElementById('orcPaciente').textContent = o.paciente;
            document.getElementById('orcDentista').textContent = o.dentista;
            document.getElementById('orcData').textContent =
                new Date(o.data_orcamento).toLocaleDateString();
            document.getElementById('orcStatus').textContent = o.status;
            document.getElementById('orcTotal').textContent =
                'R$ ' + Number(o.valor_total).toFixed(2).replace('.', ',');
        })
        .catch(err => {
            console.error('Erro ao carregar orçamento:', err);
            alert('Erro ao carregar dados do orçamento.');
        });

    /* =========================
       ITENS DO ORÇAMENTO
    ========================= */

    axios
        .get(`/teamOdonto/public/api.php?api=orcamento-itens&orcamento_id=${ORCAMENTO_ID}`)
        .then(res => {

            const tbody = document.getElementById('tabelaItens');
            tbody.innerHTML = '';

            if (res.data.length === 0) {
                tbody.innerHTML =
                    `<tr><td colspan="4" class="text-center">Nenhum item encontrado</td></tr>`;
                return;
            }

            res.data.forEach(i => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td class="text-center">${i.dente}</td>
                    <td class="text-center">${i.face}</td>
                    <td>${i.procedimento}</td>
                    <td>R$ ${Number(i.valor).toFixed(2).replace('.', ',')}</td>
                `;
                tbody.appendChild(tr);
            });
        })
        .catch(err => {
            console.error('Erro ao carregar itens:', err);
            alert('Erro ao carregar itens do orçamento.');
        });

});

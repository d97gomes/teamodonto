document.addEventListener('DOMContentLoaded', () => {

    const orcamentoId = document.getElementById('orcamentoId').value;

    const pacienteNome = document.getElementById('pacienteNome');
    const dentistaNome = document.getElementById('dentistaNome');
    const statusSelect = document.getElementById('statusSelect');

    const procedimentoSelect = document.getElementById('procedimentoSelect');
    const denteSelect = document.getElementById('denteSelect');
    const faceSelect = document.getElementById('faceSelect');

    const tabelaItens = document.getElementById('tabelaItens');
    const totalOrcamento = document.getElementById('totalOrcamento');

    const btnAdicionarItem = document.getElementById('btnAdicionarItem');

    let total = 0;

    /* =========================
       CARREGAR ORÇAMENTO
    ========================= */
    axios
        .get(`/teamOdonto/public/api.php?api=orcamentos&id=${orcamentoId}`)
        .then(res => {
            const o = res.data;
            pacienteNome.value = o.paciente;
            dentistaNome.value = o.dentista;
            statusSelect.value = o.status;
            totalOrcamento.textContent =
                'R$ ' + Number(o.valor_total).toFixed(2).replace('.', ',');
        });

    /* =========================
       PROCEDIMENTOS
    ========================= */
    axios
        .get('/teamOdonto/public/api.php?api=procedimentos')
        .then(res => {
            res.data.forEach(p => {
                procedimentoSelect.innerHTML +=
                    `<option value="${p.id}" data-valor="${p.valor}">
                        ${p.nome}
                     </option>`;
            });
        });

    /* =========================
       ITENS
    ========================= */
    function carregarItens() {
        axios
            .get(`/teamOdonto/public/api.php?api=orcamento-itens&orcamento_id=${orcamentoId}`)
            .then(res => {
                tabelaItens.innerHTML = '';
                total = 0;

                res.data.forEach(item => {
                    total += Number(item.valor);
                    tabelaItens.innerHTML += `
                        <tr>
                            <td>${item.dente}</td>
                            <td>${item.face}</td>
                            <td>${item.procedimento}</td>
                            <td>R$ ${Number(item.valor).toFixed(2)}</td>
                            <td>
                                <button class="btn btn-sm btn-danger"
                                        onclick="removerItem(${item.id})">
                                    Excluir
                                </button>
                            </td>
                        </tr>`;
                });

                totalOrcamento.textContent =
                    'R$ ' + total.toFixed(2).replace('.', ',');
            });
    }

    carregarItens();

    /* =========================
       ADICIONAR ITEM
    ========================= */
    btnAdicionarItem.addEventListener('click', () => {

        if (!procedimentoSelect.value || !denteSelect.value || !faceSelect.value) {
            alert('Preencha todos os campos.');
            return;
        }

        axios
            .post('/teamOdonto/public/api.php?api=orcamento-itens', {
                orcamento_id: orcamentoId,
                procedimento_id: procedimentoSelect.value,
                dente: denteSelect.value,
                face: faceSelect.value
            })
            .then(() => {
                procedimentoSelect.value = '';
                denteSelect.value = '';
                faceSelect.value = '';
                carregarItens();
            });
    });

    /* =========================
       REMOVER ITEM
    ========================= */
    window.removerItem = id => {
        axios
            .delete(
                `/teamOdonto/public/api.php?api=orcamento-itens&id=${id}&orcamento_id=${orcamentoId}`
            )
            .then(() => carregarItens());
    };

    /* =========================
       STATUS
    ========================= */
    statusSelect.addEventListener('change', () => {
        axios.put(
            `/teamOdonto/public/api.php?api=orcamentos&id=${orcamentoId}`,
            { status: statusSelect.value }
        );
    });

});

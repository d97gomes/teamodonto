document.addEventListener('DOMContentLoaded', () => {

    const orcamentoId = document.getElementById('orcamentoId')?.value;

    const pacienteNome = document.getElementById('pacienteNome');
    const dentistaNome = document.getElementById('dentistaNome');
    const statusSelect = document.getElementById('statusSelect');
    const dataInput = document.getElementById('dataOrcamento');

    const procedimentoSelect = document.getElementById('procedimentoSelect');
    const denteSelect = document.getElementById('denteSelect');
    const faceSelect = document.getElementById('faceSelect');

    const tabelaItens = document.getElementById('tabelaItens');
    const totalOrcamento = document.getElementById('totalOrcamento');

    const btnAdicionarItem = document.getElementById('btnAdicionarItem');
    const btnSalvarOrcamento = document.getElementById('btnSalvarOrcamento');

    let total = 0;

    if (!orcamentoId) {
        mostrarMensagem('Orçamento não informado ❌', 'danger');
        return;
    }

    /* =========================
       CARREGAR ORÇAMENTO ✅
    ========================= */
    axios
        .get(`/teamOdonto/public/api.php?api=orcamentos&id=${orcamentoId}`)
        .then(res => {

            const o = res.data;

            console.log('ORCAMENTO:', o);

            pacienteNome.value = o.paciente ?? '';
            dentistaNome.value = o.dentista ?? '';

            /* ✅ STATUS (GARANTE FUNCIONAR) */
            if (statusSelect) {
                statusSelect.value = (o.status ?? '').toLowerCase();
            }

            /* ✅ DATA (IMPORTANTE) */
            if (dataInput && o.data) {
                dataInput.value = o.data.split(' ')[0]; // YYYY-MM-DD
            }

            /* ✅ TOTAL */
            totalOrcamento.textContent =
                'R$ ' + Number(o.valor_total ?? 0).toFixed(2).replace('.', ',');

        })
        .catch(err => {
            console.error(err);
            mostrarMensagem('Erro ao carregar orçamento ❌', 'danger');
        });


    /* =========================
       CARREGAR PROCEDIMENTOS ✅
    ========================= */
    axios
        .get('/teamOdonto/public/api.php?api=procedimentos')
        .then(res => {

            procedimentoSelect.innerHTML = '<option value="">Selecione</option>';

            res.data.forEach(p => {
                procedimentoSelect.innerHTML += `
                    <option value="${p.id}" data-valor="${p.valor}">
                        ${p.nome}
                    </option>`;
            });

        })
        .catch(err => {
            console.error(err);
            mostrarMensagem('Erro ao carregar procedimentos ❌', 'danger');
        });


    /* =========================
       CARREGAR ITENS ✅
    ========================= */
    function carregarItens() {

        axios
            .get(`/teamOdonto/public/api.php?api=orcamento-itens&orcamento_id=${orcamentoId}`)
            .then(res => {

                tabelaItens.innerHTML = '';
                total = 0;

                if (!res.data.length) {
                    tabelaItens.innerHTML = `
                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                Nenhum item
                            </td>
                        </tr>
                    `;
                    return;
                }

                res.data.forEach(item => {

                    total += Number(item.valor);

                    tabelaItens.innerHTML += `
                        <tr>
                            <td class="text-center">${item.dente}</td>
                            <td class="text-center">${item.face}</td>
                            <td>${item.procedimento}</td>
                            <td class="fw-bold">
                                R$ ${Number(item.valor).toFixed(2).replace('.', ',')}
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-danger"
                                        onclick="removerItem(${item.id})">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>`;
                });

                totalOrcamento.textContent =
                    'R$ ' + total.toFixed(2).replace('.', ',');

            })
            .catch(err => {
                console.error(err);
                mostrarMensagem('Erro ao carregar itens ❌', 'danger');
            });
    }

    carregarItens();


    /* =========================
       ADICIONAR ITEM ✅
    ========================= */
    btnAdicionarItem.addEventListener('click', () => {

        if (!procedimentoSelect.value || !denteSelect.value || !faceSelect.value) {
            mostrarMensagem('Preencha todos os campos ❌', 'danger');
            return;
        }

        btnAdicionarItem.disabled = true;

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
                mostrarMensagem('Item adicionado ✅');

            })
            .catch(err => {
                console.error(err);
                mostrarMensagem('Erro ao adicionar item ❌', 'danger');
            })
            .finally(() => {
                btnAdicionarItem.disabled = false;
            });

    });


    /* =========================
       REMOVER ITEM ✅
    ========================= */
    window.removerItem = id => {

        if (!confirm('Deseja remover este item?')) return;

        axios
            .delete(`/teamOdonto/public/api.php?api=orcamento-itens&id=${id}&orcamento_id=${orcamentoId}`)
            .then(() => {
                carregarItens();
                mostrarMensagem('Item removido ✅');
            })
            .catch(err => {
                console.error(err);
                mostrarMensagem('Erro ao remover item ❌', 'danger');
            });
    };


    /* =========================
       SALVAR ORÇAMENTO ✅
    ========================= */
    btnSalvarOrcamento.addEventListener('click', () => {

        btnSalvarOrcamento.disabled = true;
        btnSalvarOrcamento.innerHTML = `
            <span class="spinner-border spinner-border-sm me-1"></span>
            Salvando...
        `;

        axios.put(
            `/teamOdonto/public/api.php?api=orcamentos&id=${orcamentoId}`,
            {
                status: statusSelect.value,
                data: dataInput?.value ?? null
            }
        )
        .then(() => {

            mostrarMensagem('Orçamento salvo com sucesso ✅');

            setTimeout(() => {
                window.location.href =
                    '/teamOdonto/public/index.php?page=orcamento-list';
            }, 1200);

        })
        .catch(err => {
            console.error(err);
            mostrarMensagem('Erro ao salvar orçamento ❌', 'danger');
        })
        .finally(() => {
            btnSalvarOrcamento.disabled = false;
            btnSalvarOrcamento.innerHTML = 'Salvar';
        });

    });

});


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

    setTimeout(() => alerta.remove(), 3000);
}
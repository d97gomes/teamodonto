document.addEventListener('DOMContentLoaded', () => {

    let itens = [];

    const pacienteBusca = document.getElementById('pacienteBusca');
    const pacienteId = document.getElementById('pacienteId');
    const pacienteResultados = document.getElementById('pacienteResultados');

    const dentistaBusca = document.getElementById('dentistaBusca');
    const dentistaId = document.getElementById('dentistaId');
    const dentistaResultados = document.getElementById('dentistaResultados');

    const procedimentoSelect = document.getElementById('procedimentoSelect');

    const denteSelect = document.getElementById('denteSelect');
    const faceSelect = document.getElementById('faceSelect');
    const valorInput = document.getElementById('valorInput');

    const tabelaItens = document.getElementById('tabelaItens');
    const totalOrcamento = document.getElementById('totalOrcamento');

    const btnAdicionarItem = document.getElementById('btnAdicionarItem');
    const btnSalvarOrcamento = document.getElementById('btnSalvarOrcamento');

    /* =========================
       AUTOCOMPLETE
    ========================= */
    function configurarBusca(input, hidden, lista, endpoint) {

        let timeout;

        input.addEventListener('input', () => {

            clearTimeout(timeout);
            const termo = input.value.trim();

            if (termo.length < 2) {
                lista.classList.add('d-none');
                return;
            }

            timeout = setTimeout(async () => {

                const res = await axios.get(
                    `/teamOdonto/public/api.php?api=${endpoint}&busca=${encodeURIComponent(termo)}`
                );

                lista.innerHTML = '';

                res.data.forEach(item => {

                    const li = document.createElement('li');
                    li.className = 'list-group-item list-group-item-action';
                    li.textContent = item.nome;

                    li.onclick = () => {
                        input.value = item.nome;
                        hidden.value = item.id;
                        lista.classList.add('d-none');
                    };

                    lista.appendChild(li);
                });

                lista.classList.remove('d-none');
            }, 300);
        });
    }

    configurarBusca(pacienteBusca, pacienteId, pacienteResultados, 'pacientes');
    configurarBusca(dentistaBusca, dentistaId, dentistaResultados, 'dentistas');

    /* =========================
       PROCEDIMENTOS
    ========================= */
    axios
        .get('/teamOdonto/public/api.php?api=procedimentos')
        .then(res => {

            res.data.forEach(p => {
                procedimentoSelect.innerHTML += `
                    <option value="${p.id}" data-valor="${p.valor}">
                        ${p.nome}
                    </option>`;
            });

        });

    procedimentoSelect.addEventListener('change', () => {

        const opt = procedimentoSelect.selectedOptions[0];
        valorInput.value = opt ? Number(opt.dataset.valor).toFixed(2) : '';

    });

    /* =========================
       ADICIONAR ITEM
    ========================= */
    btnAdicionarItem.addEventListener('click', () => {

        if (!procedimentoSelect.value || !denteSelect.value || !faceSelect.value) {
            mostrarMensagem('Preencha todos os campos do item ❌', 'danger');
            return;
        }

        const opt = procedimentoSelect.selectedOptions[0];

        itens.push({
            procedimento_id: procedimentoSelect.value,
            procedimento: opt.textContent.trim(),
            dente: denteSelect.value,
            face: faceSelect.value,
            valor: Number(opt.dataset.valor)
        });

        procedimentoSelect.value = '';
        denteSelect.value = '';
        faceSelect.value = '';
        valorInput.value = '';

        renderizarItens();
        mostrarMensagem('Item adicionado ✅', 'success');
    });

    function renderizarItens() {

        tabelaItens.innerHTML = '';
        let total = 0;

        itens.forEach((item, index) => {

            total += item.valor;

            tabelaItens.innerHTML += `
                <tr>
                    <td class="text-center">${item.dente}</td>

                    <td class="text-center">${item.face}</td>

                    <td>${item.procedimento}</td>

                    <td class="fw-bold">
                        R$ ${item.valor.toFixed(2)}
                    </td>

                    <td class="text-center">
                        <button class="btn btn-sm btn-outline-danger"
                                onclick="removerItem(${index})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>`;
        });

        if (!itens.length) {
            tabelaItens.innerHTML = `
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">
                        Nenhum item adicionado
                    </td>
                </tr>`;
        }

        totalOrcamento.textContent =
            'R$ ' + total.toFixed(2).replace('.', ',');
    }

    window.removerItem = index => {

        itens.splice(index, 1);
        renderizarItens();
        mostrarMensagem('Item removido 🗑', 'success');
    };

    /* =========================
       SALVAR ORÇAMENTO
    ========================= */
    btnSalvarOrcamento.addEventListener('click', async () => {

        if (!pacienteId.value || !dentistaId.value) {
            mostrarMensagem('Selecione paciente e dentista ❌', 'danger');
            return;
        }

        if (!itens.length) {
            mostrarMensagem('Adicione ao menos um item ❌', 'danger');
            return;
        }

        btnSalvarOrcamento.disabled = true;
        btnSalvarOrcamento.innerHTML = `
            <span class="spinner-border spinner-border-sm me-1"></span>
            Salvando...
        `;

        try {

            const res = await axios.post(
                '/teamOdonto/public/api.php?api=orcamentos',
                {
                    paciente_id: pacienteId.value,
                    dentista_id: dentistaId.value,
                    status: 'aberto'
                }
            );

            const orcamentoId = res.data.orcamento_id;

            for (const item of itens) {
                await axios.post(
                    '/teamOdonto/public/api.php?api=orcamento-itens',
                    {
                        orcamento_id: orcamentoId,
                        procedimento_id: item.procedimento_id,
                        dente: item.dente,
                        face: item.face
                    }
                );
            }

            mostrarMensagem('Orçamento criado com sucesso ✅', 'success');

            setTimeout(() => {
                window.location.href =
                    `index.php?page=orcamento-view&id=${orcamentoId}`;
            }, 1200);

        } catch (err) {
            console.error(err);
            mostrarMensagem('Erro ao salvar orçamento ❌', 'danger');
        } finally {
            btnSalvarOrcamento.disabled = false;
            btnSalvarOrcamento.innerHTML = 'Salvar';
        }
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

    setTimeout(() => {
        alerta.remove();
    }, 3000);
}
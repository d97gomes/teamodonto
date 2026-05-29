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
                procedimentoSelect.innerHTML +=
                    `<option value="${p.id}" data-valor="${p.valor}">
                        ${p.nome}
                     </option>`;
            });
        });

    procedimentoSelect.addEventListener('change', () => {
        const opt = procedimentoSelect.selectedOptions[0];
        valorInput.value = opt ? Number(opt.dataset.valor).toFixed(2) : '';
    });

    /* =========================
       ADICIONAR ITEM (MEMÓRIA)
    ========================= */
    btnAdicionarItem.addEventListener('click', () => {

        if (!procedimentoSelect.value || !denteSelect.value || !faceSelect.value) {
            alert('Preencha todos os campos do item.');
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
    });

    function renderizarItens() {
        tabelaItens.innerHTML = '';
        let total = 0;

        itens.forEach((item, index) => {
            total += item.valor;
            tabelaItens.innerHTML += `
                <tr>
                    <td>${item.dente}</td>
                    <td>${item.face}</td>
                    <td>${item.procedimento}</td>
                    <td>R$ ${item.valor.toFixed(2)}</td>
                    <td>
                        <button class="btn btn-sm btn-danger"
                                onclick="removerItem(${index})">
                            Excluir
                        </button>
                    </td>
                </tr>`;
        });

        if (!itens.length) {
            tabelaItens.innerHTML =
                `<tr><td colspan="5" class="text-center">
                    Nenhum item adicionado
                 </td></tr>`;
        }

        totalOrcamento.textContent =
            'R$ ' + total.toFixed(2).replace('.', ',');
    }

    window.removerItem = index => {
        itens.splice(index, 1);
        renderizarItens();
    };

    /* =========================
       SALVAR ORÇAMENTO
    ========================= */
    btnSalvarOrcamento.addEventListener('click', async () => {

        if (!pacienteId.value || !dentistaId.value) {
            alert('Selecione paciente e dentista.');
            return;
        }

        if (!itens.length) {
            alert('Adicione ao menos um item.');
            return;
        }

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

        window.location.href =
            `index.php?page=orcamento-view&id=${orcamentoId}`;
    });

});
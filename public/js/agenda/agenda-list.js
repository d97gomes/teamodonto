document.addEventListener('DOMContentLoaded', () => {

    const lista = document.getElementById('listaAgenda');
    const dataAgenda = document.getElementById('dataAgenda');
    const tipoFiltro = document.getElementById('tipoFiltro');

    dataAgenda.value = new Date().toISOString().split('T')[0];

    /* =========================
       CARREGAR AGENDA
    ========================= */
    function carregarAgenda() {

        lista.innerHTML = `
            <div class="text-muted text-center py-4">
                Carregando...
            </div>
        `;

        axios.get('/teamOdonto/public/api.php', {
            params: {
                api: 'agenda',
                data: dataAgenda.value,
                tipo: tipoFiltro?.value ?? 'dia'
            }
        })
        .then(res => {

            const agendamentos = res.data.data ?? [];
            lista.innerHTML = '';

            if (!agendamentos.length) {
                lista.innerHTML = `
                    <div class="text-muted text-center py-4">
                        Nenhum agendamento
                    </div>
                `;
                return;
            }

            agendamentos.forEach(item => {

                const badge = getBadgeStatus(item.status);
                const botoes = getBotoes(item);

                lista.innerHTML += `
                    <div class="list-group-item">

                        <div class="d-flex justify-content-between">

                            <div>
                                <strong>
                                    ${item.data} ${item.hora.substring(0,5)}
                                </strong><br>

                                <small class="text-muted">
                                    Paciente: ${item.paciente_nome}
                                </small><br>

                                <small class="text-muted">
                                    Dentista: ${item.dentista_nome}
                                </small>
                            </div>

                            <div class="text-end">
                                ${badge}
                            </div>

                        </div>

                        ${botoes}

                    </div>
                `;
            });

        })
        .catch(err => {
            console.error(err);
            lista.innerHTML = `
                <div class="text-danger text-center py-4">
                    Erro ao carregar agenda
                </div>
            `;
        });
    }

    carregarAgenda();

    dataAgenda.addEventListener('change', carregarAgenda);
    tipoFiltro?.addEventListener('change', carregarAgenda);


    /* =========================
       BOTÕES
    ========================= */
    function getBotoes(item) {

        let html = `
            <div class="d-flex justify-content-between mt-2">

                <div class="d-flex gap-2">
        `;

        /* ✅ BOTÃO VIEW (SÓ SE EXISTIR CONSULTA) */
        if (item.consulta_id) {
            html += `
                <a href="/teamOdonto/public/index.php?page=consulta-view&id=${item.consulta_id}"
                   class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-eye"></i>
                </a>
            `;
        }

        /* ✅ EDITAR AGENDA */
        html += `
            <a href="/teamOdonto/public/index.php?page=agenda-edit&id=${item.id}"
               class="btn btn-sm btn-outline-warning">
                <i class="bi bi-pencil"></i>
            </a>

            <button class="btn btn-sm btn-outline-danger"
                    onclick="excluirAgenda(${item.id})">
                <i class="bi bi-trash"></i>
            </button>
        `;

        html += `</div><div class="d-flex gap-2">`;

        /* ===== STATUS ===== */
        if (item.status === 'pendente') {
            html += `
                <button class="btn btn-sm btn-outline-success"
                    onclick="atualizarStatus(${item.id}, 'confirmado')">
                    <i class="bi bi-check-lg"></i>
                </button>

                <button class="btn btn-sm btn-outline-danger"
                    onclick="atualizarStatus(${item.id}, 'cancelado')">
                    <i class="bi bi-x-lg"></i>
                </button>
            `;
        }

        if (item.status === 'confirmado') {
            html += `
                <button class="btn btn-sm btn-outline-warning"
                    onclick="atualizarStatus(${item.id}, 'em_atendimento')">
                    <i class="bi bi-play"></i>
                </button>
            `;
        }

        if (item.status === 'em_atendimento') {
            html += `
                <a href="/teamOdonto/public/index.php?page=consulta-create&agenda_id=${item.id}"
                   class="btn btn-sm btn-outline-success">
                    <i class="bi bi-journal-medical"></i>
                </a>
            `;
        }

        html += `
                </div>
            </div>
        `;

        return html;
    }

    /* =========================
       STATUS
    ========================= */
    function getBadgeStatus(status) {

        const mapa = {
            pendente: 'secondary',
            confirmado: 'primary',
            em_atendimento: 'warning',
            concluido: 'success',
            cancelado: 'danger'
        };

        return `
            <span class="badge bg-${mapa[status] || 'secondary'}">
                ${formatarStatus(status)}
            </span>
        `;
    }

    function formatarStatus(status) {
        const mapa = {
            pendente: 'Pendente',
            confirmado: 'Confirmado',
            em_atendimento: 'Em Atendimento',
            concluido: 'Concluído',
            cancelado: 'Cancelado'
        };

        return mapa[status] || status;
    }

    /* =========================
       UPDATE STATUS
    ========================= */
    window.atualizarStatus = function (id, status) {

        axios.put('/teamOdonto/public/api.php?api=agenda-status', {
            id: id,
            status: status
        })
        .then(() => carregarAgenda())
        .catch(err => console.error(err));
    };

    /* =========================
       DELETE
    ========================= */
    window.excluirAgenda = function (id) {

        if (!confirm('Deseja excluir este agendamento?')) return;

        axios.delete(`/teamOdonto/public/api.php?api=agenda&id=${id}`)
            .then(() => location.reload())
            .catch(err => console.error(err));
    };

});

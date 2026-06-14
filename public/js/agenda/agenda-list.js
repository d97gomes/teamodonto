document.addEventListener('DOMContentLoaded', () => {

    const lista = document.getElementById('listaAgenda');
    const dataAgenda = document.getElementById('dataAgenda');
    const tipoFiltro = document.getElementById('tipoFiltro');

    dataAgenda.value = new Date().toISOString().split('T')[0];

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
        }).then(res => {

            const agendamentos = res.data.data ?? [];
            lista.innerHTML = '';

            if (!agendamentos.length) {
                lista.innerHTML = `
                    <div class="text-muted text-center py-4">
                        Nenhum agendamento para este período
                    </div>
                `;
                return;
            }

            agendamentos.forEach(item => {

                let badge = 'secondary';
                let botoes = '';

                /* ===== PENDENTE ===== */
                if (item.status === 'pendente') {
                    badge = 'secondary';
                    botoes = `
                        <div class="d-flex justify-content-end gap-2 mt-2">

                            <button class="btn btn-sm btn-outline-primary"
                                onclick="atualizarStatus(${item.id}, 'confirmado')">
                                <i class="bi bi-check-lg"></i>
                            </button>

                            <button class="btn btn-sm btn-outline-danger"
                                onclick="atualizarStatus(${item.id}, 'cancelado')">
                                <i class="bi bi-x-lg"></i>
                            </button>

                        </div>
                    `;
                }

                /* ===== CONFIRMADO ===== */
                if (item.status === 'confirmado') {
                    badge = 'primary';
                    botoes = `
                        <div class="d-flex justify-content-end mt-2">

                            <button class="btn btn-sm btn-outline-warning"
                                onclick="atualizarStatus(${item.id}, 'em_atendimento')">
                                <i class="bi bi-play"></i>
                            </button>

                        </div>
                    `;
                }

                /* ===== EM ATENDIMENTO ===== */
                if (item.status === 'em_atendimento') {
                    badge = 'warning';
                    botoes = `
                        <div class="d-flex justify-content-end mt-2">

                            <a href="/teamOdonto/public/index.php?page=consulta-view&agenda_id=${item.id}"
                               class="btn btn-sm btn-outline-success">
                                <i class="bi bi-journal-medical"></i>
                            </a>

                        </div>
                    `;
                }

                /* ===== ✅ CONCLUÍDO (NOVO BOTÃO) ===== */
                if (item.status === 'concluido') {
                    badge = 'success';
                    botoes = `
                        <div class="d-flex justify-content-end mt-2">

                            <a href="/teamOdonto/public/index.php?page=consulta-view&agenda_id=${item.id}"
                               class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i>
                            </a>

                        </div>
                    `;
                }

                if (item.status === 'cancelado') {
                    badge = 'danger';
                }

                lista.innerHTML += `
                    <div class="list-group-item d-flex justify-content-between align-items-center">

                        <div>
                            <strong>${item.data} ${item.hora.substring(0,5)}</strong><br>
                            Paciente ${item.paciente_nome}<br>
                            Dentista ${item.dentista_nome}
                        </div>

                        <div class="text-end d-flex flex-column align-items-end">

                            <span class="badge bg-${badge} mb-2">
                                ${item.status.replace('_', ' ')}
                            </span>

                            ${botoes}

                        </div>

                    </div>
                `;
            });
        });
    }

    dataAgenda.addEventListener('change', carregarAgenda);
    tipoFiltro?.addEventListener('change', carregarAgenda);

    carregarAgenda();

    /* ===== ATUALIZAR STATUS ===== */
    window.atualizarStatus = function (id, status) {
        axios.put('/teamOdonto/public/api.php?api=agenda-status', {
            id: id,
            status: status
        }).then(() => {
            carregarAgenda();
        });
    };

});

document.addEventListener('DOMContentLoaded', () => {

    const lista = document.getElementById('listaAgenda');
    const dataAgenda = document.getElementById('dataAgenda');
    const tipoFiltro = document.getElementById('tipoFiltro');

    // Data padrão = hoje
    dataAgenda.value = new Date().toISOString().split('T')[0];

    function carregarAgenda() {

        lista.innerHTML = `
            <div class="text-muted text-center py-3">
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

            // ✅ AJUSTE PRINCIPAL: ler data corretamente
            const agendamentos = res.data.data ?? [];
            lista.innerHTML = '';

            if (!agendamentos.length) {
                lista.innerHTML = `
                    <div class="text-muted text-center py-3">
                        Nenhum agendamento para este período
                    </div>
                `;
                return;
            }

            agendamentos.forEach(item => {

                let badge = 'secondary';
                let botoes = '';

                /* ===== STATUS: PENDENTE ===== */
                if (item.status === 'pendente') {
                    badge = 'secondary';
                    botoes = `
                        <button class="btn btn-sm btn-primary"
                            onclick="atualizarStatus(${item.id}, 'confirmado')">
                            Confirmar
                        </button>
                        <button class="btn btn-sm btn-danger ms-1"
                            onclick="atualizarStatus(${item.id}, 'cancelado')">
                            Cancelar
                        </button>
                    `;
                }

                /* ===== STATUS: CONFIRMADO ===== */
                if (item.status === 'confirmado') {
                    badge = 'primary';
                    botoes = `
                        <button class="btn btn-sm btn-warning"
                            onclick="atualizarStatus(${item.id}, 'em_atendimento')">
                            Iniciar Atendimento
                        </button>
                    `;
                }

                /* ===== STATUS: EM ATENDIMENTO ===== */
                if (item.status === 'em_atendimento') {
                    badge = 'warning';
                    botoes = `
                        <a href="/teamOdonto/public/index.php?page=consulta-view&agenda_id=${item.id}"
                           class="btn btn-sm btn-success">
                            Abrir Consulta
                        </a>
                    `;
                }

                /* ===== STATUS FINAIS ===== */
                if (item.status === 'concluido') badge = 'success';
                if (item.status === 'cancelado') badge = 'danger';

                // ✅ AJUSTE PRINCIPAL: usar nomes retornados pela API
                lista.innerHTML += `
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>${item.data} ${item.hora.substring(0,5)}</strong><br>
                            Paciente ${item.paciente_nome}<br>
                            Dentista ${item.dentista_nome}
                        </div>

                        <div class="text-end">
                            <span class="badge bg-${badge} mb-2">
                                ${item.status.replace('_', ' ')}
                            </span><br>
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

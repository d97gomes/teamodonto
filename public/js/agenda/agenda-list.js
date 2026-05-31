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
                tipo: tipoFiltro.value,
                data: dataAgenda.value
            }
        }).then(res => {

            lista.innerHTML = '';

            const dados = res.data.data ?? [];

            if (!dados.length) {
                lista.innerHTML = `
                    <div class="text-muted text-center py-3">
                        Nenhum agendamento para este período
                    </div>
                `;
                return;
            }

            dados.forEach(item => {

                let badge = 'secondary';
                let botoes = '';

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

                if (item.status === 'confirmado') {
                    badge = 'primary';
                    botoes = `
                        <button class="btn btn-sm btn-warning"
                            onclick="atualizarStatus(${item.id}, 'em_atendimento')">
                            Iniciar
                        </button>
                    `;
                }

                if (item.status === 'em_atendimento') {
                    badge = 'warning';
                    botoes = `
                        <button class="btn btn-sm btn-success"
                            onclick="atualizarStatus(${item.id}, 'concluido')">
                            Concluir
                        </button>
                    `;
                }

                if (item.status === 'concluido') badge = 'success';
                if (item.status === 'cancelado') badge = 'danger';

                lista.innerHTML += `
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>${item.data} ${item.hora.substring(0,5)}</strong><br>
                            Paciente: ${item.paciente_nome}<br>
                            Dentista: ${item.dentista_nome}
                        </div>

                        <div class="text-end">
                            <span class="badge bg-${badge} mb-2">
                                ${item.status.replace('_',' ')}
                            </span><br>
                            ${botoes}
                        </div>
                    </div>
                `;
            });

        }).catch(() => {
            lista.innerHTML = `
                <div class="text-danger text-center py-3">
                    Erro ao carregar agenda
                </div>
            `;
        });
    }

    dataAgenda.addEventListener('change', carregarAgenda);
    tipoFiltro.addEventListener('change', carregarAgenda);

    carregarAgenda();

    // Função global para update de status
    window.atualizarStatus = function (id, status) {
        axios.put('/teamOdonto/public/api.php?api=agenda-status', {
            id: id,
            status: status
        }).then(() => {
            carregarAgenda();
        });
    };

});

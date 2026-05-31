document.addEventListener('DOMContentLoaded', () => {

    let consultaId = null;

    // 1️⃣ Buscar dados da agenda (paciente e dentista)
    fetch(`/teamOdonto/public/api.php?api=agenda&data=` + new Date().toISOString().slice(0,10))
        .then(res => res.json())
        .then(lista => {
            const item = lista.find(a => a.id == AGENDA_ID);

            if (!item) return;

            document.getElementById('pacienteNome').innerText = item.paciente;
            document.getElementById('dentistaNome').innerText = `Dentista: ${item.dentista}`;
        });

    // 2️⃣ Buscar ou criar consulta
    fetch(`/teamOdonto/public/api.php?api=consulta&agenda_id=${AGENDA_ID}`)
        .then(res => res.json())
        .then(consulta => {

            if (consulta && consulta.id) {
                consultaId = consulta.id;
                document.getElementById('evolucao').value = consulta.evolucao ?? '';
                return;
            }

            // Se não existir, cria
            fetch('/teamOdonto/public/api.php?api=consulta', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ agenda_id: AGENDA_ID })
            })
            .then(res => res.json())
            .then(() => {
                return fetch(`/teamOdonto/public/api.php?api=consulta&agenda_id=${AGENDA_ID}`);
            })
            .then(res => res.json())
            .then(nova => {
                consultaId = nova.id;
            });
        });

    // 3️⃣ Finalizar consulta
    window.finalizarConsulta = function () {

        const evolucao = document.getElementById('evolucao').value;

        fetch('/teamOdonto/public/api.php?api=consulta-finalizar', {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                consulta_id: consultaId,
                agenda_id: AGENDA_ID,
                evolucao: evolucao
            })
        })
        .then(() => {
            alert('Consulta finalizada com sucesso!');
            window.location.href = '/teamOdonto/public/index.php?page=agenda';
        });
    };

});

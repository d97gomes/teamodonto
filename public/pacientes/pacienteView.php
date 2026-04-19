<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>TEAMODONTO</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/teamOdonto/css/style.css">
</head>
<body>

<?php include '../layout/sidebar.php'; ?>

<div class="content">

<?php
require_once '../../app/config/database.php';
require_once '../../app/controllers/pacienteController.php';

$db = Database::conectar();
$controller = new PacienteController($db);

$id = $_GET['id'] ?? 0;
$paciente = $controller->buscarPacientePorId((int)$id);

if (!$paciente) {
    echo "<p>Paciente não encontrado.</p>";
    exit;
}

$aba = $_GET['aba'] ?? 'dados';
?>

<h3><?= $paciente['nome']; ?></h3>

<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <a class="nav-link <?= $aba=='dados'?'active':'' ?>" href="?id=<?= $id ?>&aba=dados">Dados</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= $aba=='anamnese'?'active':'' ?>" href="?id=<?= $id ?>&aba=anamnese">Anamnese</a>
    </li>
</ul>

<?php if ($aba === 'dados'): ?>
    <p><strong>CPF:</strong> <?= $paciente['cpf']; ?></p>
    <p><strong>Telefone:</strong> <?= $paciente['telefone']; ?></p>
<?php endif; ?>

</div>

</body>
</html>

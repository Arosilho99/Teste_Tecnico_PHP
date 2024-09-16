<?php
require 'db_config.php';

$dbconn = pg_connect($conn_string);

if (!$dbconn) {
    die("Erro na conexão com o banco de dados.");
}

function buscar_agendamentos($dbconn, $nome_advogado = '', $data_agendamento = '') {
    $query = "SELECT * FROM relatorio_agendamentos";
    $conditions = [];

    if ($nome_advogado) {
        $nome_advogado = pg_escape_string($dbconn, $nome_advogado);
        $conditions[] = "\"Nome do Advogado Responsável\" ILIKE '%$nome_advogado%'";
    }

    if ($data_agendamento) {
        $data_agendamento = pg_escape_string($dbconn, $data_agendamento);
        $conditions[] = "\"Data do Agendamento\" = '$data_agendamento'";
    }

    if ($conditions) {
        $query .= " WHERE " . implode(' AND ', $conditions);
    }

    $result = pg_query($dbconn, $query);
    $agendamentos = [];
    while ($row = pg_fetch_assoc($result)) {
        $agendamentos[] = $row;
    }
    return $agendamentos;
}

$nome_pesquisa = '';
$data_pesquisa = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nome_pesquisa'])) {
        $nome_pesquisa = $_POST['nome_pesquisa'];
    }
    if (isset($_POST['data_pesquisa'])) {
        $data_pesquisa = $_POST['data_pesquisa'];
    }
}

$agendamentos = buscar_agendamentos($dbconn, $nome_pesquisa, $data_pesquisa);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Agendamentos</title>
    <link rel="stylesheet" href="estilos.css">
    <style>
        .filter-form {
            margin-bottom: 20px;
        }

        .navigation {
            position: absolute;
            top: 10px;
            left: 10px;
        }
    </style>
</head>
<body>
    <div class="navigation">
        <a href="index.php" class="btn-voltar">Voltar</a>
    </div>

    <h2>Relatório de Agendamentos</h2>

    <div class="filter-form">
        <form method="post">
            <label for="nome_pesquisa">Nome do Advogado:</label>
            <input type="text" id="nome_pesquisa" name="nome_pesquisa" placeholder="Pesquisar advogado" value="<?= htmlspecialchars($nome_pesquisa) ?>">
            
            <label for="data_pesquisa">Data do Agendamento:</label>
            <input type="date" id="data_pesquisa" name="data_pesquisa" value="<?= htmlspecialchars($data_pesquisa) ?>">

            <input type="submit" name="search" value="Pesquisar">
        </form>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Número do Processo</th>
                    <th>Nome do Advogado Responsável</th>
                    <th>Nome da Parte</th>
                    <th>Tipo de Parte</th>
                    <th>Data do Agendamento</th>
                    <th>Tipo de Agendamento</th>
                    <th>Status do Agendamento</th>
                    <th>Detalhes da Diligência</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($agendamentos) > 0): ?>
                    <?php foreach ($agendamentos as $agendamento): ?>
                    <tr>
                        <td><?= htmlspecialchars($agendamento['Número do Processo']) ?></td>
                        <td><?= htmlspecialchars($agendamento['Nome do Advogado Responsável']) ?></td>
                        <td><?= htmlspecialchars($agendamento['Nome da Parte']) ?></td>
                        <td><?= htmlspecialchars($agendamento['Tipo de Parte']) ?></td>
                        <td><?= htmlspecialchars($agendamento['Data do Agendamento']) ?></td>
                        <td><?= htmlspecialchars($agendamento['Tipo de Agendamento']) ?></td>
                        <td><?= htmlspecialchars($agendamento['Status do Agendamento']) ?></td>
                        <td><?= htmlspecialchars($agendamento['Detalhes da Diligência']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">Nenhum agendamento encontrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>
</html>

<?php pg_close($dbconn); ?>

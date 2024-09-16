<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $senha = $_POST['senha'];
    $pontuacao_minima = $_POST['pontuacao_minima'];
    require 'db_config.php';
    $dbconn = pg_connect($conn_string);

    if (!$dbconn) {
        die("Erro na conexão com o banco de dados.");
    }

    $query = "SELECT senha_lista FROM configuracoes LIMIT 1"; 
    $result = pg_query($dbconn, $query);

    if ($result) {
        $row = pg_fetch_assoc($result);
        $senha_correta = $row['senha_lista'];

        if ($senha == $senha_correta) {
            $query = "SELECT nome_completo, experiencia_php, formacao_academica, conhecimento_bd_postgresql, pontuacao_final FROM candidatos WHERE pontuacao_final >= $pontuacao_minima
                ORDER BY pontuacao_final DESC";
            $result = pg_query($dbconn, $query);

            if (pg_num_rows($result) > 0) {
                echo "<link rel='stylesheet' href='estilos.css'>";
                echo "  <style>
                        .navigation {
                            position: absolute;
                            top: 10px;
                            left: 10px;
                        }
                    </style>";
                    echo "<div class='navigation'>
                    <a href='cadastra_candidatos.php' class='btn-voltar'>Voltar</a>
                  </div>";
                echo "<h1>Lista de Candidatos</h1>";
                echo "<h3>Pontuação mínima: " . htmlspecialchars($pontuacao_minima) . "</h3>";
                echo "<div class='table-container'>
                        <table>
                            <tr>
                                <th>Nome Completo</th>
                                <th>Experiência em PHP</th>
                                <th>Formação Acadêmica</th>
                                <th>Conhecimento em Banco de Dados</th>
                                <th>Pontuação Total</th>
                            </tr>";

                while ($row = pg_fetch_assoc($result)) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row['nome_completo']) . "</td>
                            <td>" . htmlspecialchars($row['experiencia_php']) . "</td>
                            <td>" . htmlspecialchars($row['formacao_academica']) . "</td>
                            <td>" . htmlspecialchars($row['conhecimento_bd_postgresql']) . "</td>
                            <td>" . htmlspecialchars($row['pontuacao_final']) . "</td>
                          </tr>";
                }
                echo "</table></div>";
            } else {
                echo "Nenhum candidato encontrado.";
            }
        } else {
            echo "<h2>Senha incorreta! Tente novamente.</h2>";
        }
    } else {
        echo "Erro ao obter a senha do banco de dados.";
    }
    pg_close($dbconn);
}
?>

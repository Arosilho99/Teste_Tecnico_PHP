<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    require 'db_config.php';

    $dbconn = pg_connect($conn_string);

    if (!$dbconn) {
        die("Erro na conexão com o banco de dados.");
    }

    $nome_completo = $_POST['nome_completo'];
    $experiencia_php = $_POST['experiencia_php'];
    $formacao_academica = $_POST['formacao_academica'];
    $conhecimento_bd_postgresql = $_POST['conhecimento_bd_postgresql'];


    function buscar_pontos($descricao, $dbconn) {
        $query = "SELECT valor_pontos FROM depara WHERE descricao = '$descricao'";
        $result = pg_query($dbconn, $query);
        
        if ($row = pg_fetch_assoc($result)) {
            return $row['valor_pontos'];  
        }
        return 0;
    }

    $pontos_experiencia_php = buscar_pontos($experiencia_php, $dbconn);
    $pontos_formacao_academica = buscar_pontos($formacao_academica, $dbconn);
    $pontos_postgresq = buscar_pontos($conhecimento_bd_postgresql, $dbconn);

    $pontos_finais_candidato = $pontos_experiencia_php + $pontos_postgresq + $pontos_formacao_academica;

    echo "<link rel='stylesheet' href='estilos.css'>";
    echo "<div class='content'>";
    echo "<h1>Dados recebidos</h1>";
    echo "<p>Nome Completo: " . htmlspecialchars($nome_completo) . "</p>";
    echo "<hr>";
    echo "<p>Experiência em PHP: " . htmlspecialchars($pontos_experiencia_php) . " PONTOS</p>";
    echo "<hr>";
    echo "<p>Formação Acadêmica: " . htmlspecialchars($pontos_formacao_academica) . " PONTOS</p>";
    echo "<hr>";
    echo "<p>Conhecimento em Banco de Dados: " . htmlspecialchars($pontos_postgresq) . " PONTOS</p>";
    echo "<hr>";
    echo "<p>Pontuação final do candidato: " . htmlspecialchars($pontos_finais_candidato) . " PONTOS</p>";
    echo "<hr>";
    $query = "INSERT INTO candidatos (nome_completo, experiencia_php, formacao_academica, conhecimento_bd_postgresql, pontuacao_final)
              VALUES ('$nome_completo', '$pontos_experiencia_php', '$pontos_formacao_academica', '$pontos_postgresq', '$pontos_finais_candidato')";

    $query_verifica_candidato = "SELECT 1 FROM candidatos WHERE nome_completo = '$nome_completo'";
    $result_verifica_candidato = pg_query($dbconn, $query_verifica_candidato);

    if (pg_num_rows($result_verifica_candidato) == 0) {
        $result = pg_query($dbconn, $query);
        if ($result) {
            echo "<p>Dados inseridos com sucesso!</p>";
        } else {
            echo "<p>Erro ao inserir os dados.</p>";
        }
    } else {
        $query = "UPDATE candidatos SET experiencia_php = '$pontos_experiencia_php', formacao_academica = '$pontos_formacao_academica', conhecimento_bd_postgresql = '$pontos_postgresq', pontuacao_final = '$pontos_finais_candidato' WHERE nome_completo = '$nome_completo'";
        $result = pg_query($dbconn, $query);
        echo "<p>Informações do candidato $nome_completo atualizadas com sucesso</p>";
    }

    pg_close($dbconn);
echo "  <style>
        .navigation {
            position: absolute;
            top: 10px;
            left: 10px;
        }
    </style>";
    echo "<div class='navigation'>";
    echo "<a href='cadastra_candidatos.php' class='btn-voltar'>Voltar</a>";
    echo "</div>";
    echo "</div>";
}
?>

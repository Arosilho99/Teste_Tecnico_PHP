<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Cadastro Vagas RH</title>
    <link rel="stylesheet" href="estilos.css">
        <style>
        .navigation {
            position: absolute;
            top: 10px;
            left: 10px;
        }
    </style>
</head>
<body>
    <div class='navigation'>
        <a href='index.php' class='btn-voltar'>Voltar</a>
    </div>
    <h2>Formulário de Cadastro</h2>
    <form action="calcula_pontos.php" method="POST">
        <label for="nome">Nome Completo:</label>
        <input type="text" id="nome" name="nome_completo" required><br><br>

        <label for="experiencia_php">Experiência em PHP (em anos):</label>
        <select id="experiencia_php" name="experiencia_php" required>
            <option value="" disabled selected>Experiência em anos</option>
            <option value="sn">Sem experiência</option>
            <option value="1_ano">Até 1 ano</option>
            <option value="1_a_3_anos">Entre 1 e 3 anos</option>
            <option value="3_a_5_anos">Entre 3 e 5 anos</option>
            <option value="mais_de_5">Mais de 5 anos</option>
        </select><br><br>

        <label for="formacao">Formação Acadêmica:</label><br>
        <select id="formacao" name="formacao_academica" required>
            <option value="" disabled selected>Selecione sua formação</option>
            <option value="superior_em_ti">Curso superior em áreas de TI</option>
            <option value="superior_em_outras_areas">Curso superior em outras áreas</option>
            <option value="sn">Sem formação superior</option>
        </select><br><br>

        <label for="bd_postgresql">Conhecimento em Banco de Dados</label>
        <select id="bd_postgresql" name="conhecimento_bd_postgresql" required>
            <option value="" disabled selected>Possui conhecimento em quais bancos de dados</option>
            <option value="postgresql">PostgreSQL</option>
            <option value="outros">Outros Bancos de Dados</option>
            <option value="nenhum">Não tenho experiência</option>
        </select><br><br>
        <div class="submit-container">
            <input type="submit" value="Enviar">
        </div>
    </form>

    <h2>Acesso à Lista de Candidatos</h2>
    <form action="visualizar_candidatos.php" method="POST">
        <label for="senha">Digite a senha para acessar a lista de candidatos:</label><br>
        <input type="password" id="senha" name="senha" required><br><br>
          <label for="pontuacao_minima">Pontuação Mínima:</label>
        <input type="range" name="pontuacao_minima" id="pontuacao_minima" min="0" max="100" value="50" oninput="this.nextElementSibling.value = this.value">
        <output>50</output><br><br>
        <input type="submit" value="Acessar">
    </form>
</body>
</html>

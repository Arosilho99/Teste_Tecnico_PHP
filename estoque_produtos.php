<?php
require 'db_config.php';

$dbconn = pg_connect($conn_string);


if (!$dbconn) {
    die("Erro na conexão com o banco de dados.");
}

function buscar_produtos($dbconn, $chave = '') {
    $query = "SELECT * FROM produtos";
    if ($chave) {
        $chave = pg_escape_string($dbconn, $chave);
        $query .= " WHERE nome_produto ILIKE '%$chave%'";
    }

    $result = pg_query($dbconn, $query);
    $produtos = [];
    while ($row = pg_fetch_assoc($result)) {
        $produtos[] = $row;
    }
    return $produtos;
}

if (isset($_POST['add'])) {
    $nome = $_POST['nome_produto'];
    $descricao = $_POST['descricao_produto'];
    $valor = $_POST['valor_produto'];
    $quantidade = $_POST['quantidade_estoque'];

    $query = "INSERT INTO produtos (nome_produto, descricao_produto, valor_produto, quantidade_estoque) 
              VALUES ('$nome', '$descricao', '$valor', '$quantidade')";
    pg_query($dbconn, $query);
      header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    pg_query($dbconn, "DELETE FROM produtos WHERE id = $id");
}

if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $nome = $_POST['nome_produto'];
    $descricao = $_POST['descricao_produto'];
    $valor = $_POST['valor_produto'];
    $quantidade = $_POST['quantidade_estoque'];

    $query = "UPDATE produtos SET nome_produto = '$nome', descricao_produto = '$descricao', valor_produto = '$valor', quantidade_estoque = '$quantidade' WHERE id = $id";
    pg_query($dbconn, $query);
}

$chave_pesquisa = '';
if (isset($_POST['search'])) {
    $chave_pesquisa = $_POST['chave_pesquisa'];
}

$produtos = buscar_produtos($dbconn, $chave_pesquisa);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Produtos</title>
    <link rel="stylesheet" href="estilos.css">
    <style>
        .add-form, .edit-form {
            display: none;
            margin-top: 10px;
        }

        .edit-form.active {
            display: block;
        }
                .navigation {
            position: absolute;
            top: 10px;
            left: 10px;
        }
    </style>
    <script>
        function toggleAddForm() {
            var form = document.getElementById('add-form');
            form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';
        }

        function toggleEditForm(id) {
            var form = document.getElementById('edit-form-' + id);
            if (form) {
                form.classList.toggle('active');
            }
        }
    </script>
</head>
<body>
    <div class="navigation">
        <a href="index.php" class="btn-voltar">Voltar</a>
    </div>

    <h2>Lista de Produtos</h2>
    <form method="post">
        <input type="text" name="chave_pesquisa" placeholder="Pesquisar produto" value="<?= htmlspecialchars($chave_pesquisa) ?>">
        <input type="submit" name="search" value="Pesquisar">
    </form>

    <button onclick="toggleAddForm()" style="width: 100%;max-width: 500px;margin-top: 10px; padding: 10px 20px;">Novo Produto</button>

    <div id="add-form" class="add-form">
        <h2>Adicionar Novo Produto</h2>
        <form method="post">
            Nome: <input type="text" name="nome_produto" required style="width: 90%;"><br>
            Descrição: <input type="text" name="descricao_produto" required style="width: 90%;"><br>
            Valor: <input type="text" name="valor_produto" required style="width: 90%;"><br>
            Quantidade: <input type="number" name="quantidade_estoque" required style="width: 90%;"><br>
            <input type="submit" name="add" value="Adicionar Produto">
        </form>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Valor</th>
                    <th>Quantidade em Estoque</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($produtos) > 0): ?>
                    <?php foreach ($produtos as $produto): ?>
                    <tr id="row-<?= htmlspecialchars($produto['id']) ?>">
                        <td><?= htmlspecialchars($produto['nome_produto']) ?></td>
                        <td><?= htmlspecialchars($produto['descricao_produto']) ?></td>
                        <td><?= htmlspecialchars($produto['valor_produto']) ?></td>
                        <td><?= htmlspecialchars($produto['quantidade_estoque']) ?></td>
                        <td>
                            <button onclick="toggleEditForm(<?= htmlspecialchars($produto['id']) ?>)">Editar</button>
                            <form method="post" style="display:inline;box-shadow: none;background-color: transparent;">
                                <input type="hidden" name="id" value="<?= $produto['id'] ?>">
                                <input type="submit" name="delete" value="Excluir" style="padding: 5px 10px; border: none; border-radius: 4px; color: #e0e0e0; font-size: 14px; cursor: pointer; transition: background-color 0.3s; background-color: #f44336;">
                            </form>
                            <div id="edit-form-<?= htmlspecialchars($produto['id']) ?>" class="edit-form">
                                <form method="post">
                                    <input type="hidden" name="id" value="<?= $produto['id'] ?>">
                                    Nome: <input type="text" name="nome_produto" value="<?= htmlspecialchars($produto['nome_produto']) ?>"><br>
                                    Descrição: <input type="text" name="descricao_produto" value="<?= htmlspecialchars($produto['descricao_produto']) ?>"><br>
                                    Valor: <input type="text" name="valor_produto" value="<?= htmlspecialchars($produto['valor_produto']) ?>"><br>
                                    Quantidade: <input type="number" name="quantidade_estoque" value="<?= htmlspecialchars($produto['quantidade_estoque']) ?>"><br>
                                    <input type="submit" name="edit" class="edit-btn" value="Salvar">
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">Nenhum produto encontrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>
</html>

<?php pg_close($dbconn); ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="estilos.css">
	<title>Projetos</title>
	<style>
		body {
			font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
			background-color: #0d0d0d;
			margin: 0;
			padding: 0;
			display: flex;
			justify-content: center;
			align-items: center;
			height: 100vh;
			color: #f0f0f0;
			overflow: hidden;
		}

		.container {
			text-align: center;
			background: linear-gradient(145deg, #1f1f1f, #292929);
			padding: 40px;
			box-shadow: 0 8px 30px rgba(0, 0, 0, 0.6);
			border-radius: 12px;
			border: 1px solid #333;
			animation: fadeIn 1.2s ease-out;
		}

		@keyframes fadeIn {
			from { opacity: 0; transform: scale(0.95); }
			to { opacity: 1; transform: scale(1); }
		}

		h1 {
			color: #ffffff;
			font-size: 2.2rem;
			margin-bottom: 20px;
			border-bottom: 2px solid #444;
			padding-bottom: 10px;
		}

		.button-container {
			margin-top: 30px;
		}

		.button {
			display: block;
			width: 320px;
			margin: 15px auto;
			padding: 15px;
			font-size: 18px;
			color: #fff;
			background: linear-gradient(145deg, #3a7bd5, #1f5eb7);
			border: none;
			border-radius: 8px;
			text-decoration: none;
			cursor: pointer;
			transition: background-color 0.4s ease, transform 0.3s ease;
			box-shadow: 0 6px 15px rgba(0, 0, 0, 0.4);
		}

		.button:hover {
			background: linear-gradient(145deg, #1f5eb7, #3a7bd5);
			transform: translateY(-5px);
		}

		.button:active {
			transform: translateY(-2px);
		}
	</style>
</head>
<body>
	<div class="container">
		<h1>Projetos</h1>
		<div class="button-container">
			<a href="cadastra_candidatos.php" class="button">CADASTRO DE CANDIDATOS</a>
			<a href="estoque_produtos.php" class="button">ESTOQUE DE PRODUTOS</a>
			<a href="view_agendamentos.php" class="button">VIEW AGENDAMENTOS</a>
		</div>
	</div>
</body>
</html>

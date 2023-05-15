<?php

	require_once ('classes/crud.php');
	require_once ('conexao/banco.php');

	$database = new Database();
	$db = $database->getConnection();
	$crud = new Crud($db);

	
	if(isset($_GET['action'])){
		switch($_GET['action']){
			case 'create':
				$crud->create($_POST);
			break;
			case 'read':
				$rows =  $crud->read();
			break;
			case 'update':
				$crud->update($_POST);
			break;
			case 'delete':
				$crud->delete($_GET['id']);
			break;

			default:
			$rows = $crud->read();
			break;
		}
	}


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
	<title>Formulário da Banda</title>
</head>
<body>
    	<form method="POST" action="?action=create">
		<label for="banda">Nome da Banda:</label>
		<input type="text" id="nome" name="nome" required>

		<label for="genero">Gênero:</label>
		<input type="text" id="genero" name="genero" required>

		<label for="gravadora">Gravadora:</label>
		<input type="text" id="gravadora" name="gravadora" required>

		<label for="discos">Número de Discos:</label>
		<input type="number" id="num_discos" name="num_discos" required>

		<label for="albums">Quantidade de Álbuns:</label>
		<input type="number" id="qtd_albums" name="qtd_albuns" required>


		<input type="submit" value="Enviar">
	</form>

</body>
</html>



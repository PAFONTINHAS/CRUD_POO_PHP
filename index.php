<?php

//incluir o arquivo da classe e o arquivo de conexao
require_once ('classes/crud.php');
require_once ('conexao/banco.php');

$database = new Database();
$db = $database->getConnection();
$crud = new Crud($db);

//solicitacoes do usuario
if(isset($_GET['action'])){
    switch($_GET['action']){
        case 'create':
            $crud->create($_POST);
			$rows = $crud->read();
            break;
        case 'read':
            $rows = $crud->read();

            break; 
        case 'update':
			if(isset($_POST['id'])){
				$crud->update($_POST);
			}
			$rows = $crud->read();

            break;
        case 'delete':
            $crud->delete($_GET['id']);
			$rows = $crud->read();


            break;
        default:
            $rows = $crud->read();
            break;
    }
}else{
    $rows = $crud->read();
}


?>



<!DOCTYPE html>
<html>
<head>
    <title>Formulário de Banda</title>

	<style>
		/* Estilização do formulário */
form {
    max-width: 500px;
    margin: 50px auto;
    padding: 20px;
    background-color: #fff;
    box-shadow: 0px 0px 10px rgba(0,0,0,0.2);
    border-radius: 5px;
  }
  
  label {
    display: block;
    margin-bottom: 10px;
    font-size: 16px;
    font-weight: bold;
    color: #444;
  }
  
  input[type="text"],
  input[type="number"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    font-size: 16px;
    color: #444;
    border-radius: 5px;
    border: 1px solid #ccc;
    box-sizing: border-box;
  }
  
  input[type="submit"] {
    display: block;
    width: 100%;
    padding: 10px;
    margin-top: 20px;
    font-size: 16px;
    color: #fff;
    background-color: #3498db;
    border: none;
    border-radius: 5px;
    cursor: pointer;
  }
  
  input[type="submit"]:hover {
    background-color: #2980b9;
  }
  
  /* Estilização da tabela */
  table {
  border-collapse: collapse;
  width: 100%;
}

th, td {
  padding: 8px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

th {
  background-color: purple;
  color: white;
}

  tr:nth-child(even) {
    background-color: #f2f2f2;
  }
  
  tr:hover {
    background-color: #ddd;
  }
  
  a {
    color: #3498db;
    text-decoration: none;
  }
  
  .delete {
    color: #c0392b;
  }
  
  /* Responsividade */
  @media only screen and (max-width: 600px) {
    form {
      padding: 10px;
    }
  
    input[type="text"],
    input[type="number"] {
      margin-bottom: 10px;
    }
  }
  
		
	</style>

</head>
<body>

  <?php
  
  		if(isset($_GET['action']) && $_GET['action'] == 'update' && isset($_GET['id'])){

			$id = $_GET['id'];
			$result = $crud ->readOne($id);

			if(!$result){
				
				echo"Registro não encontrado.";
				exit();
			}

			$nome = $result['nome'];
			$genero = $result['genero'];
			$gravadora = $result['gravadora'];
			$num_discos = $result['num_discos'];
			$qtd_albuns = $result ['qtd_albuns'];

	?>


	<form method="POST" action="?action=update">
		<input type="hidden" name="id" value = "<?php echo $id?>">
        <label for="nome">Nome da Banda:</label>
		<input type="text" name="nome" id = "nome" value="<?php echo $nome?>">
		
        <label for="genero">Gênero:</label>
        <input type="text" id="genero" name="genero" value="<?php echo $genero?>">

        <label for="gravadora">Gravadora:</label>
        <input type="text" id="gravadora" name="gravadora"value="<?php echo $gravadora?>" >

        <label for="num_discos">Número de Discos:</label>
        <input type="number" id="num_discos" name="num_discos" value="<?php echo $num_discos?>">

         <label for="quantidade_albums">Quantidade de Álbuns:</label>
        <input type="number" id="quantidade_albums" name="qtd_albuns" value="<?php echo $qtd_albuns?>">

        <input type="submit" value="Atualizar" name="enviar">

        <a href="index.php">Voltar ao formulário de criação</a>
    </form>

	<?php 
		
	}
	else{
		
	?>

	<form method="POST" action="?action=create">
        <label for="nome">Nome da Banda:</label>
        <input type="text" id="nome" name="nome" required>

        <label for="genero">Gênero:</label>
        <input type="text" id="genero" name="genero" required>

        <label for="gravadora">Gravadora:</label>
        <input type="text" id="gravadora" name="gravadora" required>

        <label for="num_discos">Número de Discos:</label>
        <input type="number" id="num_discos" name="num_discos" required>

         <label for="quantidade_albums">Quantidade de Álbuns:</label>
        <input type="number" id="quantidade_albums" name="qtd_albuns" required>

        <input type="submit" value="Cadastrar" name="enviar">
    </form>

	<?php
	}

?>

	<div class="tabela">

	<table>
        <tr>
            <th>Id</th>
            <th>Nome da Banda</th>
            <th>Genero</th>
            <th>Gravadora</th>
            <th>Numero de discos</th>
            <th>Quantidade de Albuns</th>
            <th>Ações</th>
        </tr>
        <?php
    if (isset($rows)) {
        foreach($rows as $row){
            echo "<tr>";
            echo "<td>".$row['id']."</td>";
            echo "<td>".$row['nome']."</td>";
            echo "<td>".$row['genero']."</td>";
            echo "<td>".$row['gravadora']."</td>";
            echo "<td>".$row['num_discos']."</td>";
            echo "<td>".$row['qtd_albuns']."</td>";
            echo "<td>";
            echo "<a href='?action=update&id=".$row['id']."'>Editar</a>";
            echo "<a href='?action=delete&id=".$row['id']."' onclick='return confirm(\"Tem certeza que deseja deletar esse registro?\")' class='delete'>Excluir</a>";
            echo "</td>";
            echo "</tr>";

        }
    }else{
        echo "Não há registros a serem exibidos.";
    }
        ?>
    </table>
   
	</div>

    

</body>
</html>
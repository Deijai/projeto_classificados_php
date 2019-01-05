<?php 
require('header.php');

if (empty($_SESSION['clogin'])) {
	header("Location: login.php");
}
?>
<div class="container">
	<h2>Adicionar Anucncios</h2>

	<?php
      $c = new Categoria($pdo);
      $a = new Anuncio($pdo);

      if (isset($_POST['cadastrar'])) {
      	
      	if (!empty(['titulo']) && !empty($_POST['preco']) && !empty($_POST['descricao'])) {
      		
      		$id_usuario = $_SESSION['clogin'];
      		$categoria = addslashes($_POST['categoria']);
      		$titulo = addslashes($_POST['titulo']);
      		$preco = addslashes($_POST['preco']);
      		$descricao = addslashes($_POST['descricao']);
      		$estado = addslashes($_POST['estado']);


      		if ($categoria != '0') {
      			$a->addAnuncio($id_usuario, $categoria, $titulo, $descricao, $preco, $estado);
      			echo '<div class="alert alert-success" role="alert">Anuncio adicionado com sucesso!</div>';
      		}
      	}

      }
	?>

	<form method="POST" enctype="multipart/form-data">

		

		<div class="form-group">
          <label for="categoria">Categoria</label>
          <select name="categoria" id="categoria" class="form-control">
			  <option value="0">Selecione:</option>

			  <?php foreach($c->listarCategorias() as $categorias): ?>
			  <option value="<?php echo $categorias['id'] ?>"><?php echo utf8_encode($categorias['nome']); ?></option>
			  <?php endforeach; ?>

		</select>
        </div>

        <div class="form-group">
          <label for="titulo">Titutlo</label>
          <input type="text" name="titulo" id="titulo" class="form-control">
        </div>
        
        <div class="form-group">
          <label for="preco">Preço</label>
          <input type="number" name="preco" id="preco" class="form-control">
        </div>

        <div class="form-group">
          <label for="descricao">Descricao</label>
          <textarea name="descricao" id="descricao" class="form-control"></textarea>
        </div>

         <div class="form-group">
          <label for="estado">Estado de conservação</label>
          <select name="estado" id="estado" class="form-control">
          	<option value="0">Ruim</option>
          	<option value="1">Bom</option>
          	<option value="2">Ótimo</option>
          </select>
        </div>


        <input type="submit" name="cadastrar" value="Cadastrar" class="btn btn-default">
        
      </form>




</div>

<?php 
require('footer.php');
?>
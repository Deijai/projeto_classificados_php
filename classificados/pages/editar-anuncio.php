<?php 
require('header.php');
$c = new Categoria($pdo);
$a = new Anuncio($pdo);

if (empty($_SESSION['clogin'])) {
	header("Location: login.php");
}
$id_anuncio = isset($_GET['id']) ? $_GET['id'] : "";

if (isset($id_anuncio) && !empty($id_anuncio)) {
    $anuncio = $a->getAnuncio($id_anuncio);
}else{
    header("Location: meus-anuncios.php");
}
?>
<div class="container">
	<h2>Adicionar Anucncios</h2>

	<?php


      if (isset($_POST['salvar'])) {
      	
      	if (!empty(['titulo']) && !empty($_POST['preco']) && !empty($_POST['descricao'])) {
      		
      		$id_usuario = $_SESSION['clogin'];
      		$categoria = addslashes($_POST['categoria']);
      		$titulo = addslashes($_POST['titulo']);
      		$preco = addslashes($_POST['preco']);
      		$descricao = addslashes($_POST['descricao']);
            $estado = addslashes($_POST['estado']);
            
            if (isset($_FILES['fotos'])) {
                $fotos = $_FILES['fotos'];
            }else{
                $fotos = array();
            }

      		if ($categoria != '0') {
                  //$a->addAnuncio($id_usuario, $categoria, $titulo, $descricao, $preco, $estado);
                  $a->editAnuncio($categoria, $titulo, $descricao, $preco, $estado, $fotos, $id_anuncio);
      			echo '<div class="alert alert-success" role="alert">Anuncio editado com sucesso!</div>';
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
			  <option value="<?php echo $categorias['id'] ?>" <?php echo ($anuncio['id_categoria'] == $categorias['id']) ? 'selected="selected"': '' ?>><?php echo utf8_encode($categorias['nome']); ?></option>
			  <?php endforeach; ?>

		</select>
        </div>

        <div class="form-group">
          <label for="titulo">Titutlo</label>
          <input type="text" name="titulo" id="titulo" class="form-control" value="<?php echo $anuncio['titulo']?>">
        </div>
        
        <div class="form-group">
          <label for="preco">Preço</label>
          <input type="number" name="preco" id="preco" class="form-control" value="<?php echo $anuncio['preco']?>">
        </div>

        <div class="form-group">
          <label for="descricao">Descricao</label>
          <textarea name="descricao" id="descricao" class="form-control" ><?php echo $anuncio['descricao']?></textarea>
        </div>

         <div class="form-group">
          <label for="estado">Estado de conservação</label>
          <select name="estado" id="estado" class="form-control">
          	<option value="0" <?php echo (isset($anuncio['estado']) == '0') ? 'selected="selected"': "" ?>>Ruim</option>
          	<option value="1" <?php echo (isset($anuncio['estado']) == '1') ? 'selected="selected"': "" ?>>Bom</option>
          	<option value="2" <?php echo (isset($anuncio['estado']) == '2') ? 'selected="selected"': "" ?>>Ótimo</option>
          </select>
        </div>

        <div class="form-group">
          <label for="add_fotos">Fotos</label>
          <input type="file" name="fotos[]" multiple id="fotos" class="form-control"/>

          <div class="panel panel-default">
              <div class="panel panel-heading">
                Fotos do Anuncio
              </div>
              <div class="panel panel-body">
                  <?php if($a->getImagem($id_anuncio) > 0 ): ?>
                  <?php foreach($a->getImagem($id_anuncio) as $imagens): ?>
                    <div class="foto_item">
                    <img class="img-thumbnail" src="../imagens/anuncios/<?php echo $imagens['url']; ?>" height="60" />
                    <a href="excluir-imagem.php?id=<?php echo $imagens['id']; ?>" class="btn btn-danger">Excluir</a>
                    </div>
                  <?php endforeach; ?>
                  <?php else: ?>
                  <?php echo '<div class="alert alert-warning" role="alert">Nenhuma imagem para esse anuncio!</div>';  ?>
                <?php endif; ?>
              </div>

          </div>
        </div>


        <input type="submit" name="salvar" value="Salvar" class="btn btn-success">
        
      </form>




</div>

<?php 
require('footer.php');
?>
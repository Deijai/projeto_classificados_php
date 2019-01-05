<?php 
require('header.php');

if (empty($_SESSION['clogin'])) {
	header("Location: login.php");
}
?>
<div class="container">

	<h2>Meus Anuncios</h2>

	<a href="add-anuncio.php" class="btn btn-primary">Adicionar anuncio</a><br>

	<?php
     $a = new Anuncio($pdo);
     $anuncios = $a->meusAnuncios($_SESSION['clogin']);
	?>

	<table class="table table-striped">

		<thead>
			<tr>
				<th>Foto</th>
				<th>Titulo</th>
				<th>Descrição</th>
				<th>Valor</th>
				<th>Ação</th>
			</tr>
		</thead>

		<tbody>
			<?php if($anuncios > 0): ?>
			<?php foreach ($anuncios as $anuncio):?>
				
			<tr>
				<td>
					<?php if(!empty($anuncio['url'])): ?>
					<img height="60"  src="../imagens/anuncios/<?php echo $anuncio['url'] ?>">
					<?php else: ?>
					<img border="0" height="60" src="../imagens/anuncios/photo-camera.png">
				<?php endif; ?>
				</td>
				<td><?php echo $anuncio['titulo'] ?></td>
				<td><?php echo $anuncio['descricao'] ?></td>
				<td>R$ <?php echo number_format($anuncio['preco'], 2,',','.') ?></td>
				<td> <a class="btn btn-danger" href="excluir-anuncio.php?id=<?php echo $anuncio['id']; ?>">Excluir</a>  <a class="btn btn-warning" href="editar-anuncio.php?id=<?php echo $anuncio['id']; ?>">Editar</a></td>
			</tr>
		      <?php endforeach; ?>
		      <?php else: ?>
               <?php echo '<div class="alert alert-warning" role="alert">Não existem anuncios cadastrados.</div>'; ?>
		      <?php endif; ?>
		</tbody>
		
	</table>
	
</div>

<?php 
require('footer.php');
?>
<?php require('header.php')?>
 <?php
  $a = new Anuncio($pdo);
  $u = new Usuario($pdo);

  if(isset($_GET['id']) && !empty($_GET['id'])){
	$id = addslashes($_GET['id']);
}else{
	header("Location: index.php");
}
  $todos_anuncios = $a->getAllAnuncio();
  $todos_usuarios = $u->getAllUsuario();
  $info = $a->getAnuncio($id);
  $imagens = $a->getImagem($info['id']);

 ?>
    <div class="container-fluid">
      
      <div class="row">

        <div class="col-sm-4">
            <div class="carousel slide" data-ride="carousel" id="meuCarousel">

                <div class="carousel-inner" role="listbox">

                    <?php if($imagens > 0): ?>

                        <?php foreach($imagens as $chave => $foto): ?>
                            <div class="item <?php echo ($chave == '0') ? 'active' : '' ?>">
                                <img src="../imagens/anuncios/<?php echo $foto['url'] ?>"/>
                            </div>
                        <?php endforeach; ?>

                    <?php else: ?>
                    <?php echo '<div class="alert alert-warning" role="alert">Não existem fotos para esse anuncio.</div>'; ?>
                    <?php endif; ?>
                </div>

                <a class="left carousel-control" href="#meuCarousel" role="button" data-slide="prev"><span><</span></a>
                <a class="right carousel-control" href="#meuCarousel" role="button" data-slide="next"><span>></span></a>


            </div>
        </div>

        <div class="col-sm-8">
        <h1><?php echo $info['titulo'] ?></h1>
        <h4><?php echo utf8_encode($info['categoria']) ?></h4>
        <p><?php echo $info['descricao'] ?></p><br/>
        <p>Anunciante: <?php echo $info['usuario'] ?></p><br/><br/><br/>
        <h3>R$ <?php echo number_format($info['preco'], 2,',','.') ?></h3>
        <h4>Telefone do Anunciante: <?php echo $info['telefone'] ?> </h4>

        </div>

      </div>
    </div>
    
<?php require('footer.php')?>

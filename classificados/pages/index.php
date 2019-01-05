<?php require('header.php')?>
 <?php
  $a = new Anuncio($pdo);
  $u = new Usuario($pdo);
  $c = new Categoria($pdo);

$filtros = array(
        'categoria' => '',
        'preco' => '',
        'estado' => ''
);

  if (isset($_GET['filtros'])) {

    $filtros = $_GET['filtros'];   

  }


  $todos_anuncios = $a->getAllAnuncio($filtros);
  $todos_usuarios = $u->getAllUsuario();
  $t = count($todos_anuncios);
  $p = 1;
  if (isset($_GET['p']) && !empty($_GET['p'])) {
    $p = addslashes($_GET['p']);
  }

  $limitePorPagina = 4;
  $total_pagina = ceil($t / $limitePorPagina);

  $ultimos_anuncios = $a->ultimosAnuncios($p, $limitePorPagina, $filtros);
  $categorias = $c->listarCategorias();

 ?>
    <div class="container-fluid">
      <div class="jumbotron">
        <h2>Nós temos hoje <?php echo count($todos_anuncios); ?> anúncios</h2>
        <p>E mais de <?php echo count($todos_usuarios);?> usuários cadastrados.</p>
        
      </div>

      <div class="row">
        <div class="col-sm-3">
          <h4>Pesquisa Avançada</h4>

          <form method="GET">

            <div class="form-group">
             <label for="categoria">Categoria:</label>
              <select id="categoria" name="filtros[categoria]" class="form-control">
                <option></option>
                <?php foreach ($categorias as $cat): ?>
                  <option value="<?php echo $cat['id']; ?>" <?php echo($cat['id'] == $filtros['categoria']) ? 'selected="selected"' : '' ?>><?php echo utf8_encode($cat['nome']); ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="form-group">
             <label for="preco">Preço:</label>
              <select id="preco" name="filtros[preco]" class="form-control">
                <option></option>
                  <option value="0-50" <?php echo($filtros['preco'] == '0-50') ? 'selected="selected"':'' ?>>0 - 50</option>
                  <option value="51-100" <?php echo($filtros['preco'] == '51-100') ? 'selected="selected"' :'' ?>>51 - 100</option>
                  <option value="101-200" <?php echo($filtros['preco'] == '101-200') ? 'selected="selected"':'' ?>>101 - 200</option>
                  <option value="201-500" <?php echo($filtros['preco'] == '201-500') ? 'selected="selected"':'' ?>>201 - 500</option>
                  <option value="+501" <?php echo($filtros['preco'] == '+500') ? 'selected="selected"':'' ?>> acima de 501</option>
              </select>
            </div>

            <div class="form-group">
             <label for="estado">Estado:</label>
              <select id="estado" name="filtros[estado]" class="form-control">
                <option></option>
                  <option value="0" <?php echo($filtros['estado'] == '0') ? 'selected="selected"':'' ?>>Ruim</option>
                  <option value="1" <?php echo($filtros['estado'] == '1') ? 'selected="selected"':'' ?>>Bom</option>
                  <option value="2" <?php echo($filtros['estado'] == '2') ? 'selected="selected"':'' ?>>Ótimo</option>
              </select>
            </div>

            <div class="form-group">

              <input type="submit" name="pesquisar" value="Pesquisar" class="form-control btn btn-primary">
              
            </div>
            
          </form>

      
      </div>

        <div class="col-sm-9">
        <h4>Ultimos anuncios</h4>
        <table class="table table-striped">
          <thead>
             <tr>
               <th>Foto</th>
               <th>Titulo/Categoria</th>
               <th>Preço</th>
            </tr>
          </thead>

        <tbody>
            <?php if($ultimos_anuncios > 0): ?>
            <?php foreach($ultimos_anuncios as $ultimo_anuncio): ?>
              <tr>
                  <td>
                      <?php if(!empty($ultimo_anuncio['url'])): ?>
                      <img height="60"  src="../imagens/anuncios/<?php echo $ultimo_anuncio['url'] ?>">
                      <?php else: ?>
                      <img border="0" height="60" src="../imagens/anuncios/photo-camera.png">
                    <?php endif; ?>
                </td>

                <td>
                    <a href="produto.php?id=<?php echo $ultimo_anuncio['id'] ?>"><?php echo $ultimo_anuncio['titulo'];?></a><br/>
                    <?php echo utf8_encode( $ultimo_anuncio['categoria']);?>
                </td>

                <td>
                  <?php echo number_format($ultimo_anuncio['preco'], 2,",","."); ?>
                </td>

              </tr>
            <?php endforeach; ?>

          <?php else: ?>
            <?php echo '<div class="alert alert-warning" role="alert">Não existem anuncios nessa pagina.</div>'; ?>
          <?php endif; ?>
        </tbody>
      </table>
      <ul class="pagination">
        <?php for($i = 1; $i <= $total_pagina; $i++): ?>
        <li class="<?php echo ($p==$i)?'active':''; ?>">
          <a href="index.php?p=<?php echo $i; ?>"> <?php echo($i); ?></a>
        </li>
        <?php endfor; ?>
      </ul>
        </div>
      </div>
    </div>
    
<?php require('footer.php')?>

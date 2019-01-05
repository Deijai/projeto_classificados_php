<?php 
require('../config/config.php'); 
require('../classes/usuario.class.php');
require('../classes/anuncio.class.php');
require('../classes/categoria.class.php');
?>
<!doctype html>
<html lang="pt-br">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <title>Classificados!</title>
  </head>
  <body>
    <nav class="navbar navbar-inverse">

      <div class="container-fluid">

        <div class="navbar-header">
          <a href="./" class="navbar-brand">Classificados</a>
        </div>

        <?php
          $u = new Usuario($pdo);
        ?>

        <ul class="nav navbar-nav navbar-right">
          <?php if(isset($_SESSION['clogin']) && !empty($_SESSION['clogin'])): ?>
           <li><a href="./"><?php echo $u->mostrarUsuario($_SESSION['clogin'])['nome']; ?></a></li>
            <li><a href="meus-anuncios.php">Meus anuncios</a></li>
            <li><a href="sair.php">Sair</a></li>
          <?php else: ?>
            <li><a href="cadastrar-usuario.php">Cadastre-se</a></li>
            <li><a href="login.php">Login</a></li>
        <?php endif; ?>
        </ul>

      </div>
    </nav>


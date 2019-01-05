<?php 
require('header.php');
?>

<div class="container">

	<?php
      $u = new Usuario($pdo);

      if (isset($_POST['logar'])) {
      	
      	if (!empty($_POST['email']) && !empty($_POST['senha'])) {
      		
      		$email = addslashes($_POST['email']);
      		$senha = addslashes(md5($_POST['senha']));

      		if ($u->fazerLogin($email, $senha)) {
      			$_SESSION['clogin'] = $u->fazerLogin($email, $senha)['id'];
      			header("Location: index.php");
      		}else{
      			echo '<div class="alert alert-danger" role="alert">Email/Senha Inválidos</div>';
      		}
      	}

      }
	?>

	<h2>Fazer Login</h2>
      <form method="POST">

        <div class="form-group">
          <label for="nome">Seu email</label>
          <input type="text" name="email" id="email" class="form-control">
        </div>

        <div class="form-group">
          <label for="senha">Senha</label>
          <input type="password" name="senha" id="senha" class="form-control">
        </div>

        <input type="submit" name="logar" value="Logar-se" class="btn btn-default">
        
      </form>
	
</div>


<?php require('footer.php')?>
<?php 
require('header.php');
?>

    <div class="container">

      <?php
        $u = new Usuario($pdo);

        if (isset($_POST['cadastrar'])) {

          if (!empty($_POST['nome']) && !empty($_POST['email']) && !empty($_POST['senha']) && !empty($_POST['telefone'])) {

            $nome = addslashes($_POST['nome']);
            $email = addslashes($_POST['email']);
            $senha = addslashes(md5($_POST['senha']));
            $telefone = addslashes($_POST['telefone']);

            if ($u->existeEmail($email)) {
                $u->cadastrarUsuario($nome, $email, $senha, $telefone);
                 echo '<div class="alert alert-success" role="alert">Cadastro realizado com sucesso. <a href="login.php">Faça login aqui </a></div>';
            }else{
              echo '<div class="alert alert-danger" role="alert">Email já cadastrado</div>';
            }

            # code...
          } else{
            echo '<div class="alert alert-warning" role="alert">Favor, preencha todos os campos</div>';
          }
          
        }
      ?>

      <h2>Cadastre-se</h2>
      <form method="POST">

        <div class="form-group">
          <label for="nome">Seu nome</label>
          <input type="text" name="nome" id="nome" class="form-control">
        </div>

        <div class="form-group">
          <label for="email">Seu e-mail</label>
          <input type="text" name="email" id="email" class="form-control">
        </div>

        <div class="form-group">
          <label for="senha">Senha</label>
          <input type="password" name="senha" id="senha" class="form-control">
        </div>

        <div class="form-group">
          <label for="nome">Seu telefone</label>
          <input type="text" name="telefone" id="telefone" class="form-control">
        </div>

        <input type="submit" name="cadastrar" value="Cadastre-se" class="btn btn-default">
        
      </form>
      
    </div>
    
<?php require('footer.php')?>

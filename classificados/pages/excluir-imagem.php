<?php
require('../config/config.php'); 
require('../classes/anuncio.class.php');
if (empty($_SESSION['clogin'])) {
	header("Location: login.php");
}
if(!empty($_GET['id'])){
    $id_imagem = addslashes($_GET['id']);
    $a = new Anuncio($pdo);
    $a->excluirImagem($id_imagem);
    header("Location: meus-anuncios.php");
}else{
    header("Location: login.php");
}
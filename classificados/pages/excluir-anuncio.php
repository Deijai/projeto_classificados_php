<?php
require('../config/config.php'); 
require('../classes/anuncio.class.php');
if (empty($_SESSION['clogin'])) {
	header("Location: login.php");
}
if (!empty($_GET['id'])) {
	$id = addslashes($_GET['id']);
    $a = new Anuncio($pdo);
    $a->excluirAnuncio($id);
    header("Location: meus-anuncios.php");

}
<?php
/**
 * 
 */
class Categoria {

	private $pdo;
	private $array;
	
	function __construct($pdo)
	{
		$this->pdo = $pdo;
	}

	public function listarCategorias(){
		$sql = "SELECT * FROM categorias";
		$sql = $this->pdo->query($sql);
		$sql->execute();

		if ($sql->rowCount() > 0) {
			$this->array = $sql->fetchAll();
			return $this->array;
		}else {
			return false;
		}


	}
}
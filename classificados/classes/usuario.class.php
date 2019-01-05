<?php
/**
 * 
 */
class Usuario {

    private $id;
	private $nome;
	private $email;
	private $telefone;
	private $senha;
	private $pdo;
	private $array;

	function __construct($pdo)
	{
		$this->pdo = $pdo;
	}

	public function getAllUsuario(){
		$sql = "SELECT * FROM usuarios";
		$sql = $this->pdo->query($sql);
		$sql->execute();

		if($sql->rowCount() > 0){
			$this->array = $sql->fetchAll(PDO::FETCH_ASSOC);
		}else {
			return false;
		}

		return $this->array;
	}


	public function existeEmail($email){
		$this->email = $email;

		$sql = "SELECT email FROM usuarios WHERE email = :email";
		$sql = $this->pdo->prepare($sql);
		$sql->bindValue(':email', $this->email);
		$sql->execute();

		if ($sql->rowCount() > 0) {
			return false;
		}else{
			return true;
		}
	}


	public function cadastrarUsuario($nome, $email, $senha, $telefone){
		$this->nome = $nome;
		$this->email = $email;
		$this->senha = $senha;
		$this->telefone = $telefone;

		$sql = "INSERT INTO usuarios (nome, email, senha, telefone) VALUES (:nome, :email, :senha, :telefone)";
		$sql = $this->pdo->prepare($sql);
		$sql->bindValue(':nome', $this->nome);
		$sql->bindValue(':email', $this->email);
		$sql->bindValue(':senha', $this->senha);
		$sql->bindValue(':telefone', $this->telefone);
		$sql->execute();

	}


	public function fazerLogin($email, $senha){
		$this->email = $email;
		$this->senha = $senha;

		$sql = "SELECT * FROM usuarios WHERE email = :email AND senha = :senha";
		$sql = $this->pdo->prepare($sql);
		$sql->bindValue(':email', $this->email);
		$sql->bindValue(':senha', $this->senha);
		$sql->execute();

		if ($sql->rowCount() > 0) {
			$this->array = $sql->fetch(PDO::FETCH_ASSOC);
			return $this->array;
		}else{
			return false;
		}

	}

	public function mostrarUsuario($id){
		$this->id = $id;

		$sql = "SELECT * FROM usuarios WHERE id = :id";
		$sql = $this->pdo->prepare($sql);
		$sql->bindValue(':id', $this->id);
		$sql->execute();

		if ($sql->rowCount() > 0) {
			$this->array = $sql->fetch();
			return $this->array;
		}else{
			return false;
		}

	}

}
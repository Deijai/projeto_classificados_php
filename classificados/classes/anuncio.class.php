<?php

/**
 * 
 */
class Anuncio {

	private $pdo;
	private $array;
	private $id;
	private $id_anuncio;
	private $descricao;
	private $titulo;
	private $categoria;
	private $preco;
	private $estado;
	private $fotos;
	
	function __construct($pdo)
	{
		$this->pdo = $pdo;
	}

	public function getAllAnuncio($filtros){
		$filtrosStrings = array("1=1");
		if (!empty($filtros['categoria'])) {
			$filtrosStrings[] = "anuncios.id_categoria = :id_categoria";
		}

		if (!empty($filtros['preco'])) {
			$filtrosStrings[] = "anuncios.preco BETWEEN :preco1 AND :preco2";
		}

		if (!empty($filtros['estado'])) {
			$filtrosStrings[] = "anuncios.estado = :estado";
		}

		$sql = "SELECT * FROM anuncios WHERE ".implode(' AND ', $filtrosStrings);
		$sql = $this->pdo->prepare($sql);

		if (!empty($filtros['categoria'])) {
			$sql->bindValue(':id_categoria', $filtros['categoria']);
		}

		if (!empty($filtros['preco'])) {
			$preco = explode('-', $filtros['preco']);
			$sql->bindValue(':preco1', $preco[0]);
			$sql->bindValue(':preco2', $preco[1]);
		}

		if (!empty($filtros['estado'])) {
			$sql->bindValue(':estado', $filtros['estado']);
		}
		
		$sql->execute();

		if($sql->rowCount() > 0){
			$this->array = $sql->fetchAll(PDO::FETCH_ASSOC);
		}else{
			return false;
		}

		return $this->array;
	}

	public function getAnuncio($id){
		$this->id = $id;

		$sql = "SELECT *,(select categorias.nome 
		from categorias where categorias.id = anuncios.id_categoria) 
		as categoria, (select usuarios.nome 
		        from usuarios where usuarios.id = anuncios.id_usuario) 
				as usuario FROM anuncios WHERE id = :id";
		$sql = $this->pdo->prepare($sql);
		$sql->bindValue(':id', $this->id);
		$sql->execute();

		if($sql->rowCount() > 0){
			$this->array = $sql->fetch(PDO::FETCH_ASSOC);
		}else{
			return false;
		}

		return $this->array;
	}


	public function meusAnuncios($id_usuario){
		$this->id = $id_usuario;
		$sql = "SELECT *, (select anuncios_imagens.url from anuncios_imagens where anuncios_imagens.id_anuncio = anuncios.id limit 1) as url FROM anuncios WHERE id_usuario = :id_usuario";
		$sql = $this->pdo->prepare($sql);
		$sql->bindValue(':id_usuario', $this->id);
		$sql->execute();

		if ($sql->rowCount() > 0) {
			$this->array = $sql->fetchAll();
			return $this->array;
		}else{
			return false;
		}
	}

	public function addAnuncio($id_usuario, $id_categoria, $titulo, $descricao, $preco, $estado){
		$this->id =$id_usuario;
		$this->categoria = $id_categoria;
		$this->titulo = $titulo;
		$this->descricao = $descricao;
		$this->preco = $preco;
		$this->estado = $estado;

		$sql = "INSERT INTO anuncios (id_usuario, id_categoria, titulo, descricao, preco, estado) 
		        VALUES (:id_usuario, :id_categoria, :titulo, :descricao, :preco, :estado)";
		$sql = $this->pdo->prepare($sql);
		$sql->bindValue(':id_usuario', $this->id);
		$sql->bindValue(':id_categoria', $this->categoria);
		$sql->bindValue(':titulo', $this->titulo);
		$sql->bindValue(':descricao', $this->descricao);
		$sql->bindValue(':preco', $this->preco);
		$sql->bindValue(':estado', $this->estado);
		$sql->execute();

	}

	public function editAnuncio($id_categoria, $titulo, $descricao, $preco, $estado, $fotos, $id_anuncio){
		$this->categoria = $id_categoria;
		$this->titulo = $titulo;
		$this->descricao = $descricao;
		$this->preco = $preco;
		$this->estado = $estado;
		$this->id_anuncio = $id_anuncio;
		$this->fotos = $fotos;

		$sql = "UPDATE anuncios SET id_categoria = :id_categoria, titulo = :titulo, descricao = :descricao, preco = :preco,
									estado = :estado WHERE id = :id_anuncio";
		$sql = $this->pdo->prepare($sql);
		$sql->bindValue(':id_categoria', $this->categoria);
		$sql->bindValue(':titulo', $this->titulo);
		$sql->bindValue(':descricao', $this->descricao);
		$sql->bindValue(':preco', $this->preco);
		$sql->bindValue(':estado', $this->estado);
		$sql->bindValue(':id_anuncio', $this->id_anuncio);
		$sql->execute();

		if (count($this->fotos > 0)) {
			for ($i=0; $i < count($this->fotos['tmp_name']) ; $i++) { 

				$tipo = $this->fotos['type'][$i];
				$tipo_imagem = array('image/jpeg', 'image/png');

				if (in_array($tipo, $tipo_imagem)) {
					$caminho = 'C:/xampp/htdocs/php_oo/bw7/projetos/classificados/imagens/anuncios/';
					$extensao = ".jpg";
					$tmp_name = md5(time().rand(0,99999)).$extensao;
					move_uploaded_file($this->fotos['tmp_name'][$i], $caminho.$tmp_name);
					$lag = 300;
					$alt = 300;

					list($lag_original, $alt_original) = getimagesize($caminho.$tmp_name);
					$ratio = $lag_original / $alt_original;
					
					if ($lag/$alt > $ratio) {
						$lag = $alt * $ratio;
					} else {
						$alt = $lag / $ratio;
					}

					$image_final = imagecreatetruecolor($lag, $alt);
					if ($tipo == 'image/jpeg') {
						$image_orignal = imagecreatefromjpeg($caminho.$tmp_name);
					}else{
						$image_orignal = imagecreatefrompng($caminho.$tmp_name);
					}
					
					imagecopyresampled($image_final, $image_orignal, 0, 0, 0, 0, $lag, $alt, $lag_original, $alt_original);

					header("Content-Type: image/png");
					imagejpeg($image_final, $caminho.$tmp_name, 100);

					$sql = "INSERT INTO anuncios_imagens (id_anuncio, url) VALUES (:id_anuncio, :url)";
					$sql = $this->pdo->prepare($sql);
					$sql->bindValue(":id_anuncio", $this->id_anuncio);
					$sql->bindValue(":url", $tmp_name);
					$sql->execute();

					header("Location: meus-anuncios.php");
					
				}
			}
		}

	}


	public function getImagem($id_anuncio){
		$this->id_anuncio = $id_anuncio;

		$sql = "SELECT * FROM anuncios_imagens WHERE id_anuncio = :id_anuncio";
		$sql = $this->pdo->prepare($sql);
		$sql->bindValue(':id_anuncio', $this->id_anuncio);
		$sql->execute();

		if($sql->rowCount() > 0){
			$this->array = $sql->fetchAll(PDO::FETCH_ASSOC);
		}else{
			return false;
		}

		return $this->array;

	}

	public function excluirAnuncio($id){
		$this->id = $id;

		$sql = "DELETE FROM anuncios WHERE id = :id";
		$sql = $this->pdo->prepare($sql);
		$sql->bindValue(':id', $this->id);
		$sql->execute();

	}

	public function excluirImagem($id_imagem){
		$this->id = $id_imagem;

		$sql = "DELETE FROM anuncios_imagens WHERE id = :id_imagem";
		$sql = $this->pdo->prepare($sql);
		$sql->bindValue(':id_imagem', $this->id);
		$sql->execute();

	}

	public function ultimosAnuncios($pages, $limitePorPagina, $filtros){

		$filtrosStrings = array("1=1");
		if (!empty($filtros['categoria'])) {
			$filtrosStrings[] = "anuncios.id_categoria = :id_categoria";
		}

		if (!empty($filtros['preco'])) {
			$filtrosStrings[] = "anuncios.preco BETWEEN :preco1 AND :preco2";
		}

		if (!empty($filtros['estado'])) {
			$filtrosStrings[] = "anuncios.estado = :estado";
		}
		
		

		$offset = ($pages - 1) * $limitePorPagina;
		$sql = "SELECT *, (select anuncios_imagens.url 
		        from anuncios_imagens where anuncios_imagens.id_anuncio = anuncios.id limit 1) 
				as url, (select categorias.nome 
		        from categorias where categorias.id = anuncios.id_categoria) 
				as categoria FROM anuncios WHERE ".implode(' AND ', $filtrosStrings)." ORDER BY id DESC limit $offset, $limitePorPagina";
		$sql = $this->pdo->prepare($sql);
		if (!empty($filtros['categoria'])) {
			$sql->bindValue(':id_categoria', $filtros['categoria']);
		}

		if (!empty($filtros['preco'])) {
			$preco = explode('-', $filtros['preco']);
			$sql->bindValue(':preco1', $preco[0]);
			$sql->bindValue(':preco2', $preco[1]);
		}

		if (!empty($filtros['estado'])) {
			$sql->bindValue(':estado', $filtros['estado']);
		}
		
		$sql->execute();

		if($sql->rowCount() > 0){
			$this->array = $sql->fetchAll(PDO::FETCH_ASSOC);
		}else{
			return false;
		}

		return $this->array;
	}
}
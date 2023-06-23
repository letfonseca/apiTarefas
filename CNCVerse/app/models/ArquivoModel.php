<?php

namespace App\Models;

use Core\Model\Model;

class ArquivoModel extends Model
{

	private $id;
	private $id_usuario;
	private $id_categoria;
	private $titulo;
	private $descricao;
	private $arquivo;
	private $extensao;
	private $tamanho;
	private $visualizacoes;
	private $ativo;
	private $deleted_at;
	private $updated_at;
	private $created_at;


	public function __get($atributo)
	{
		return $this->$atributo;
	}

	public function __set($atributo, $valor)
	{
		$this->$atributo = $valor;
	}

	//validar se um cadastro pode ser feito
	public function validarCadastro()
	{
		$valido = true;

		if (strlen($this->__get('titulo')) < 3) {
			$valido = false;
		}

		return $valido;
	}

	//recuperar um categoria por e-mail
	public function getArquivoPorNome()
	{
		$query = "select id, titulo from arquivos where titulo = :titulo";
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':titulo', $this->__get('titulo'));
		$stmt->execute();

		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}

	//salvar
	public function salvar()
	{

		$query = "insert into arquivos 
						(id_usuario, id_categoria, titulo, descricao, arquivo, extensao, tamanho, visualizacoes, ativo) 
						values 
						(:id_usuario, :id_categoria, :titulo, :descricao, :arquivo, :extensao, :tamanho, :visualizacoes, :ativo)";
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
		$stmt->bindValue(':id_categoria', $this->__get('id_categoria'));
		$stmt->bindValue(':titulo', $this->__get('titulo'));
		$stmt->bindValue(':descricao', $this->__get('descricao'));
		$stmt->bindValue(':arquivo', $this->__get('arquivo'));
		$stmt->bindValue(':extensao', $this->__get('extensao'));
		$stmt->bindValue(':tamanho', $this->__get('tamanho'));
		$stmt->bindValue(':visualizacoes', $this->__get('visualizacoes'));
		$stmt->bindValue(':ativo', $this->__get('ativo'));
		$stmt->execute();

		$this->__set('id', $this->db->lastInsertId());

		return $this;
	}

	public function rowbackArquivo($id)
	{
		// $query = "delete from usuarios where id = :id_usuario";
		$query = "delete from arquivos where id = :id_arquivo";
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id_arquivo', $id);
		$stmt->execute();

		return true;
	}

	public function getArquivos()
	{
		$sql = "select a.id, a.id_usuario, a.id_categoria, a.titulo, a.descricao, a.arquivo, a.extensao, 
		a.tamanho, a.visualizacoes, a.ativo, a.created_at, 
		c.nome as categoria from arquivos as a inner join 
			categorias as c on a.id_categoria = c.id";

		return $this->db->query($sql)->fetchAll();
	}

	//recuperar uma arquivo por id
	public function getArquivoPorId($id)
	{
		$query = "select a.id, a.id_usuario, a.id_categoria, a.titulo, a.descricao, a.arquivo, a.extensao, a.tamanho, a.visualizacoes, a.ativo, a.created_at, 
		c.nome as categoria from arquivos as a inner join categorias as c on a.id_categoria = c.id and a.id = :id";
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id', $id);
		$stmt->execute();

		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}
































	public function getTotalCategorias()
	{
		$query = "select count(id) as qtdeCategorias from categorias";

		return $this->db->query($query)->fetchObject()->qtdeUsuarios;
	}

	public function deletarCategoria($id)
	{
		// $query = "delete from usuarios where id = :id_usuario";
		$query = "update categorias set ativo = 0, deleted_at = NOW() where id = :id_categoria";
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id_categoria', $id);
		$stmt->execute();

		return true;
	}



	//atualizar
	public function atualizar()
	{

		$query = "update categorias set nome = :nome, updated_at = NOW() where id=:id";

		$stmt = $this->db->prepare($query);

		$stmt->bindValue(':nome', $this->__get('nome'));

		$stmt->bindValue(':id', $this->__get('id'));

		$stmt->execute();

		return $this;
	}
}

<?php


namespace BlogDeNotas\Estructuras;

use BlogDeNotas\Interfaces\InterfaceCategory;
use BlogDeNotas\Modelos\Category;

class CategoryStructure implements InterfaceCategory
{

	private string $sqlCreateCategory = "INSERT INTO blog_notas.categorias(usuario_uuid, nombre_categoria) VALUES (:usuario_uuid, :nombre_categoria)";

	private string $sqlReadCategorys = "SELECT id, nombre_categoria FROM blog_notas.categorias WHERE usuario_uuid = :uuidUser";

	private string $sqlDeleteCategory = "DELETE FROM blog_notas.categorias WHERE id = :id AND usuario_uuid = :uuidUser";

	private \PDO $db;

	public function __construct(\PDO $db)
	{

		$this->db = $db;

	}

	//CREAR UNA CATEGORIA
	public function createCategory(string $nombre, string $uuidUser): bool
	{
		try
		{
			$stmt = $this->db->prepare($this->sqlCreateCategory);

			if(!$stmt->execute(['usuario_uuid' => $uuidUser , 'nombre_categoria' => $nombre])) throw new \PDOException('Error al crear categoria');

		} catch (\PDOException $e)
		{
			throw new \PDOException($e->getMessage());
		}

		return true;
	}



	//LEER TODAS LAS CATEGORIAS
	public function readCategorys(string $uuidUser): array
	{
		
		try
		{
			$stmt = $this->db->prepare($this->sqlReadCategorys);

			if(!$stmt->execute(['uuidUser' => $uuidUser])) throw new \PDOException('Error al crear categoria');

		} catch (\PDOException $e)
		{
			throw new \PDOException($e->getMessage());
		}

		$categorias = [];

		foreach($stmt->fetchAll(\PDO::FETCH_ASSOC) as $index => $array)
		{
			$categoria = [];

			foreach($array as $propiedades => $valor)
			{
				$categoria[$propiedades] = $valor; 
			}

			$categorias[] = new Category($categoria);
		}


		return $categorias;
	}



	//ELIMINAR UNA CATEGORIA
	public function deleteCategory(string $id, string $uuidUser): bool
	{
		try
		{
			$stmt = $this->db->prepare($this->sqlDeleteCategory);

			if(!$stmt->execute(['id' => $id, 'uuidUser' => $uuidUser])) throw new \PDOException('Error al crear categoria');

		} catch (\PDOException $e)
		{
			throw new \PDOException($e->getMessage());
		}

		return true;	
	}
}
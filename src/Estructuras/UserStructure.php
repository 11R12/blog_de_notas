<?php


namespace BlogDeNotas\Estructuras;

use BlogDeNotas\Modelos\User;
use BlogDeNotas\Interfaces\InterfaceUser;



class UserStructure implements InterfaceUser
{
	private string $sqlForSaveUser = "INSERT blog_notas.usuarios(uuid, correo, password, nombre, numero_telefono) VALUES (:uuid, :correo, :password, :nombre, :numero_telefono)" ;
	private string $sqlForReadUser = "SELECT * FROM blog_notas.usuarios WHERE correo = :correo";
	private string $sqlForUpdateUser = "UPDATE blog_notas.usuarios SET correo = :correo, password = :password, nombre = :nombre, numero_telefono = :numero_telefono WHERE uuid = :uuid";
	private string $sqlForDeleteUser = "DELETE FROM blog_notas.usuarios WHERE uuid = :uuid"; 


	private \PDO $db;

	public function __construct(\PDO $conexion)
	{

		$this->db = $conexion;
		
	}



	#Guardar user
	public function saveUserWith(User $user): bool
	{

		try
		{
			$stmt = $this->db->prepare($this->sqlForSaveUser);
			$stmt->execute($user->toArray());

		}catch(\PDOException $e)
		{
			echo 'Error al guardar user (Guardar esto en un LOG)';
			echo $e->getMessage();

			return false;
		}


		return true;

	}


	#obtener los datos de un user
	public function readUserWith(string $correo): User
	{

	   	try
		{
			$stmt = $this->db->prepare($this->sqlForReadUser);
			$stmt->execute(['correo' => $correo]);

		}catch(\PDOException $e)
		{

			throw new \PDOException($e->getMessage());

		}

		return new User($stmt->fetch(\PDO::FETCH_ASSOC));
		
	}



	#Actualizar los datos de un usuario
	public function updateDataUserFor(User $user): bool
	{

		try
		{
			$stmt = $this->db->prepare($this->sqlForUpdateUser);

			if(!$stmt->execute($user->dataToUpdate())) return false;

		}catch(\PDOException $e)
		{

			throw new \PDOException($e->getMessage());

		}

		return true;

	}



	#eliminar usuario
	public function deleteUserWith(string $uuid): bool
	{

		try
		{
			$stmt = $this->db->prepare($this->sqlForDeleteUser);

			if(!$stmt->execute(['uuid' => $uuid])) return false;

		}catch(\PDOException $e)
		{

			throw new \PDOException($e->getMessage());

		}

		return true;
		
	}

	

}
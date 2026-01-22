<?php

namespace BlogDeNotas\Infraestructuras;

use BlogDeNotas\Interfaces\DatabaseInterface;


class PdoInfraestructure implements DatabaseInterface{

	private \PDO $pdo;

	public function __construct(\PDO $pdo){

		$this->pdo = $pdo;

	}




	
	public function saveUser(string $sql, array $userArray): bool 
	{
		try {

			$stmt = $this->pdo->prepare($sql);

			$stmt->bindParam(':uuid', $userArray['uuid'], \PDO::PARAM_LOB);
			$stmt->bindParam(':nombre', $userArray['nombre'], \PDO::PARAM_STR);
			$stmt->bindParam(':correo', $userArray['correo'], \PDO::PARAM_STR);
			$stmt->bindParam(':password', $userArray['password'], \PDO::PARAM_STR);
			$stmt->bindParam(':numero_telefono', $userArray['numero_telefono'], \PDO::PARAM_STR);

			return (bool) $stmt->execute();

		} catch (\PDOException $e){

			throw new \Exception('Error al procesar solicitud: No se pudo guardar un user','',$e); 
		}
		
	}





	public function readUser(string $sql, string $correo): array{
		try{

			$stmt = $this->pdo->prepare($sql);

			$stmt->bindParam(':correo', $correo, \PDO::PARAM_STR);

			if(!$stmt->execute()) throw new \Exception('No existe user con correo proporcionado o ha sido mal escrito');

			return $stmt->fetch(\PDO::FETCH_ASSOC);

		}catch(\PDOException $e){
			throw new \Exception('Error al procesar solicitud: No se pudo leer un user', '', $e);
		}
	}





	public function updateUser(string $sql, array $userArray): bool{
		try{

			$stmt = $this->pdo->prepare($sql);

			$stmt->bindParam(':uuid', $userArray['uuid'], \PDO::PARAM_LOB);
			$stmt->bindParam(':correo', $userArray['correo'], \PDO::PARAM_STR);
			$stmt->bindParam(':password', $userArray['password'], \PDO::PARAM_STR);
			$stmt->bindParam(':nombre', $userArray['nombre'], \PDO::PARAM_STR);
			$stmt->bindParam(':numero_telefono', $userArray['numero_telefono'], \PDO::PARAM_STR);

			return (bool) $stmt->execute();

		}catch(\PDOException $e){
			throw new \Exception($e->getMessage(), '', $e);
		}
	}





	public function deleteUser(string $sql, string $uuid): bool{
		try{

			$stmt = $this->pdo->prepare($sql);

			$stmt->bindParam(':uuid', $uuid, \PDO::PARAM_LOB);

			return (bool) $stmt->execute();

		}catch(\PDOException $e){

			throw new \Exception('Error al procesar solicitud: no se pudo eliminar un user','', $e);
		}
	}




	public function existsEmailInDb(string $sql, string $correo): bool
	{
		try{
			$stmt = $this->pdo->prepare($sql);

			$stmt->bindParam(':correo', $correo, \PDO::PARAM_STR);

			return $stmt->execute();

		}catch(\PDOException $e){
			throw new \Exception('Error: no se pudo verificar existencia de Email en la DB','',$e);
		}
	}




	public function getPasswordOfUser($sql, $correo): string {

		try{

			$stmt = $this->pdo->prepare($sql);

			$stmt->bindValue(':correo', $correo, \PDO::PARAM_STR);

			$stmt->execute();

			$pass = $stmt->fetch(\PDO::FETCH_ASSOC);

			return $pass['password'];

		}catch(\PDOException $e){
			throw new \Exception('Error: no se pudo obtener la constraseña del user','',$e);
		}
	}
}
<?php


namespace BlogDeNotas\Estructuras;

use BlogDeNotas\Interfaces\InterfaceUser;
use BlogDeNotas\Interfaces\DatabaseInterface;
use BlogDeNotas\Modelos\User;
use Ramsey\Uuid\Uuid;
use Exception;

class UserStructure implements InterfaceUser{

	private string $sqlForSaveUser = "INSERT blog_notas.usuarios(uuid, correo, password, nombre, numero_telefono) VALUES (:uuid, :correo, :password, :nombre, :numero_telefono)" ;
	private string $sqlForReadUser = "SELECT * FROM blog_notas.usuarios WHERE correo = :correo";
	private string $sqlForUpdateUser = "UPDATE blog_notas.usuarios SET correo = :correo, password = :password, nombre = :nombre, numero_telefono = :numero_telefono WHERE uuid = :uuid";
	private string $sqlForDeleteUser = "DELETE FROM blog_notas.usuarios WHERE uuid = :uuid"; 
	private string $sqlExistsUser = "SELECT EXISTS( SELECT 1 FROM blog_notas.usuarios WHERE correo = :correo ) AS existe";
	private string $sqlForGetOnlyPassword = "SELECT password FROM blog_notas.usuarios WHERE correo = :correo";

	#objeto connection a la DB
	private DatabaseInterface $database;

	//Nota: estoy dependiendo de \PDO directamente. Crear interfaz 
	public function __construct(DatabaseInterface $database){
		$this->database = $database;
	}




	#guardar un user
	public function saveUserWith(User $user): bool{
		try{

			$userArray = $user->toArray();

			$userArray['uuid'] = Uuid::fromString($userArray['uuid'])->getBytes();

			return $this->database->saveUser($this->sqlForSaveUser, $userArray);

		}catch(\Exception $e){
			throw new \Exception('Fallo al guardar usuario','',$e);
		}
	}




	#Leer los datos de un User
	public function readUserWith(string $correo): User {
	   	try{

			$userArray = $this->database->readUser($this->sqlForReadUser, $correo);

			return new User($userArray, false);

		}catch(\Exception $e){
			throw new \Exception($e->getMessage(), '', $e);
		}
	}

	//Diseñar como captar el dato que el user quiere actualizar
	//de momento, se obtenemos todos los datos sin distinguir cual
	//Por supuesto, debe haber un proceso de validacion. De momento, pense
	//en ajustar el Modelo para guardar dicho dato en una variable o array en 
	//caso de ser varios y no actualizar no reemplazarlo en el momento

	#Actualizar los datos de un usuario
	public function updateDataUserFor(User $user): bool{
		try{

			$result = $this->database->updateUser($this->sqlForUpdateUser, $user->toArray());

			return $result;

		}catch(\Exception $e){
			throw new \Exception($e->getMessage(), '', $e);
		}
	}




	#eliminar usuario
	public function deleteUserWith(string $uuid): bool{
		try{

			$uuid = Uuid::fromString($uuid)->getBytes();

			$result = $this->database->deleteUser($this->sqlForDeleteUser, $uuid);

			return (bool) $result;

		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
	}





	public function existsEmail(string $correo): bool{
		try{
			return $this->database->existsEmailInDb($this->sqlExistsUser, $correo);

		}catch(\Exception $e){
			throw new \Exception('Error al procesar solicitud: verificar existencia del correo en la base de dato','',$e);
		}

	}





	public function getPasswordWhitEmail(string $correo): string{
		try{
			return $this->database->getPasswordOfUser($this->sqlForGetOnlyPassword, $correo);

		} catch (\Exception $e){
			throw new \Exception('Error: no se pudo procesar la solicitid de obtener la contraseña','',$e);
		}
	}
}
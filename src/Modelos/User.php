<?php

namespace BlogDeNotas\Modelos;

use Ramsey\Uuid\Uuid;


class User{

	private array $data; 

	public function __construct(array $data, bool $new = true)
	{
		//Si el usuario es nuevo, hashseamos su contraseña y le asiganmos un UUID
		if($new){

			$data['password'] = $this->encryptPass($data['password']);

			$data['uuid'] = $this->generateUuid();
		}
		
		$this->data = $data;
	}





	//GETTERS

	#nombre
	public function getNombre(): string{
		return $this->data['nombre'];
	}

	#correo
	public function getCorreo(): string{
		return $this->data['correo'];
	}

	#correo
	public function getPassword(): string{
		return $this->data['password'];
	}

	#telefono
	public function getTelefono(): string{
		return $this->data['numero_telefono'];
	}

	#uuid
	public function getUuid(): string{
		return $this->data['uuid'];
	}





	//SETTERS

	#nombre
	public function setNombre(string $nombre): void{
		$this->data['nombre'] = $nombre;
	}

	#correo
	public function setCorreo(string $correo): void{
		$this->data['correo'] = $correo;
	}

	#telefono
	public function setTelefono(string $telefono): void{
		$this->data['numero_telefono'] = $telefono;
	}

	#telefono
	public function setPassword(string $pass): void{
		$this->data['password'] = $pass;
	}

	public function toArray(): array{
		return $this->data;
	}





	//METODOS a usar cuando se CREA un nuevo USER

	#Encryptar los el PASS del USER
	private function encryptPass(mixed $pass): string{
		return password_hash($pass, PASSWORD_BCRYPT);
	}

	#Generarle un UUID 
	private function generateUuid(): string {
		return Uuid::uuid4()->toString();
		//Nota: Debo considerar si delegarle esto a la Abstraccion SQL
	}

}
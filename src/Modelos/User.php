<?php

namespace BlogDeNotas\Modelos;


class User{

	private array $data; 

	public function __construct(array $data)
	{
		$this->data = $data ;
	}

	//El user puede ver los siguientes datos

	#nombre
	public function getNombre(): string
	{

		return $this->data['nombre'];

	}

	#correo
	public function getCorreo(): string
	{
		
		return $this->data['correo'];

	}

	#telefono
	public function getTelefono(): string
	{
		
		return $this->data['numero_telefono'];

	}

	#uuid
	public function getUuid(): string
	{
		
		return $this->data['uuid'];

	}



	//El user puede editar los siguientes datos

	#nombre
	public function setNombre(string $nombre): void
	{

		$this->data['nombre'] = $nombre;

	}

	#correo
	public function setCorreo(string $correo): void
	{
		
		$this->data['correo'] = $correo;

	}

	#telefono
	public function setTelefono(string $telefono): void
	{
		
		$this->data['numero_telefono'] = $telefono;

	}

	#telefono
	public function setPassword(string $pass): void
	{
		
		$this->data['password'] = $pass;

	}




	//Metodos para la trata de informacion

	public function toArray(): array
	{

		return $this->data;

	}




	public function dataToUpdate(): array
	{

		$dataToUpdate['correo'] = $this->data['correo'];
		$dataToUpdate['password'] = $this->data['password'];
		$dataToUpdate['nombre'] = $this->data['nombre'];
		$dataToUpdate['numero_telefono'] = $this->data['numero_telefono'];
		$dataToUpdate['uuid'] = $this->data['uuid'];

		return $dataToUpdate;

	}






}
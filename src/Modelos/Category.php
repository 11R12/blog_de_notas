<?php


namespace BlogDeNotas\Modelos;




class Category{

	private array $categoria;


	public function __construct(array $categoria)
	{
		$this->categoria = $categoria;
	}

	public function getNombre():string
	{
		return $this->categoria['nombre_categoria'];
	}

	public function getId():string
	{
		return $this->categoria['id'];
	}

	public function getUuidUser():string
	{
		return $this->categoria['usuario_uuid'];
	}


	public function toArray(): array 
	{
		return $this->categoria;
	}
}
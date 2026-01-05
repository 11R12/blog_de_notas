<?php

namespace BlogDeNotas\Modelos;

class Note {

	private array $nota;
	private array $dataUpdate;


	public function __construct(array $nota)
	{
		$this->nota = $nota;
		
	}


	//El usuario puede ver el siguiente contenido

	#categoria
	public function getCategoriaId():int
	{

		return (int)($this->nota['categoria_id']);

	}

	#Titulo
	public function getTitulo():string
	{

		return $this->nota['titulo'];

	}

	#contenido
	public function getContenido():string
	{

		return $this->nota['contenido'];

	}

	#fecha de creacion
	public function getFechaDeCreacion():string 
	{

		return $this->nota['fecha_creacion'];

	}

	#ultima fecha de actualizacion
	public function getFechaDeActualizacion():string
	{

		return $this->nota['fecha_actualizacion'];

	}


	//El usuario puede editar el siguiente contenido

	#titulo de la nota
	public function setTitulo(string $titulo): void{

		$this->nota['titulo'] = $titulo;

	}

	#conteido de la nota
	public function setContenido(string $contenido): void{

		$this->nota['contenido'] = $contenido;

	}

	#categoria de la nota
	public function setCategoria(string $categoria): void{

		$this->nota['categoria_id'] = $categoria;

	}





	//Para el desarrollador


	#uuid de la nota
	public function getUuid()
	{

		return $this->nota['uuid'];
		
	}

	#uuid del user al que hace referencia
	public function getUuidUserReference()
	{

		return $this->nota['usuario_uuid'];

	}

	#id posicional de la base de datos
	public function getId()
	{

		return $this->nota['id'];

	}


	public function toArray():array
	{
		return $this->nota;

	}

	public function dataUpdateToArray():array 
	{
		$this->dataUpdate['uuid'] = $this->nota['uuid'];
		$this->dataUpdate['titulo'] = $this->nota['titulo'];
		$this->dataUpdate['contenido'] = $this->nota['contenido'];
		$this->dataUpdate['categoria_id'] = $this->nota['categoria_id'];
		$this->dataUpdate['usuario_uuid'] = $this->nota['usuario_uuid'];

		return $this->dataUpdate;


	}
	
}
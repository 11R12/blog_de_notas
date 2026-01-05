<?php
//Forzar tipado stricto
declare(strict_types = 1);

//Incluir el autocargador de composer para las clases e interfaces
include("../../vendor/autoload.php");

use BlogDeNotas\Database\Database;
use BlogDeNotas\Estructuras\NoteEstruct;
use BlogDeNotas\Estructuras\UserStructure;

include("../include.php");

#1. Para leer todas las notas del usuario necesitamos su UUID (PK -> FK de la notas)
$forAllUsers = new UserStructure(database::getConnection());
$allNotes = new NoteEstruct(Database::getConnection()); 

#UUID user
$uuidUser = $forAllUsers->readUserWith('melendezGmail.com')->getUuid();

#2. Ejecutamos la funcion readALLNotes
try 
{
	#retorna array de objetos (index => obj)
	$notas = $allNotes->readAllNotes($uuidUser);

	if(count($notas) !== 0)
	{

		foreach($notas as $index => $nota)
		{	

			echo PHP_EOL . "titulo:  {$nota->getTitulo()}" . PHP_EOL; 

		}

	} else 
	{

		echo "[No hay notas]";

	}


}catch(\PDOException $e)
{	
	echo 'No se pudieron obtener las notas del USER';
	echo $e->getMessage();

}


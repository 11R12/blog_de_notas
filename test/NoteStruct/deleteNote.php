<?php
//Forzar tipado stricto
declare(strict_types = 1);

//Incluir el autocargador de composer para las clases e interfaces
include("../../vendor/autoload.php");

use BlogDeNotas\Database\Database;
use BlogDeNotas\Estructuras\NoteEstruct;
use BlogDeNotas\Estructuras\UserStructure;

include("../include.php");

$forAllUsers = new UserStructure(database::getConnection());
$allNotes = new NoteEstruct(Database::getConnection()); 


#1. Para ELIMINAR una NOTA ESPECIFICA necesitamos el UUID(PK) de la nota y UUID(FK) del usuario


#UUID del user
$userUuid = $forAllUsers->readUserWith('rosberttttGmail.com')->getUuid(); 

#UUID de la nota
$noteUuid = $allNotes->readANote($userUuid, "140")->getUuid();

#2. Ejecutamos la funcion
try {

	if($allNotes->deleteNote($userUuid, $noteUuid)) 
	{
		echo "Una nota ha sido eliminada";
	}

} catch(\PDOException | \RuntimeException $e)
{
	echo PHP_EOL . "NO SE BORRO NADA" . PHP_EOL;
	echo $e->getMessage();

}


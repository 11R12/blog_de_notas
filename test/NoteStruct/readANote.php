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


#1. Para leer una nota especifica necesitamos el UUID del user (FK) y ID de la nota;


#UUID del user
$userUuid = $forAllUsers->readUserWith('melendezGmail.com')->getUuid(); 

#ID note
$id = "13";

#Nota
$nota = $allNotes->readANote($userUuid, $id);



foreach ($nota->toArray() as $propiedad => $valor)
{
	echo PHP_EOL . "{$propiedad}: {$valor}" . PHP_EOL;
}
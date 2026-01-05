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


#UUID del user
$userUuid = $forAllUsers->readUserWith('melendezGmail.com')->getUuid(); 

#categoria ID
$categoria_id = 8; #Debe ser una categoria asociada al usuario

#5. Ejecutamos la funcion filtrar
try{


	$notas = $allNotes->filterCategoryAndCrationDate($userUuid, $categoria_id, false);

	foreach($notas as $index => $nota)
	{	

		echo PHP_EOL . $nota->getTitulo() . PHP_EOL; 

	}

} catch (\PDOException $e)
{

	echo $e->getMessage();

}
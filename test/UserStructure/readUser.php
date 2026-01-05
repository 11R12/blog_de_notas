<?php
//Forzar tipado stricto
declare(strict_types = 1);

//Incluir el autocargador de composer para las clases e interfaces
include("../../vendor/autoload.php");

use BlogDeNotas\Database\Database;
use BlogDeNotas\Estructuras\UserStructure;

include("../include.php");

$forAllUsers = new UserStructure(database::getConnection());

$user = $forAllUsers->readUserWith("melendezGmail.com");

foreach($user->toArray() as $propiedad => $valor)
{
	echo PHP_EOL . "{$propiedad}: {$valor}" . PHP_EOL;
}
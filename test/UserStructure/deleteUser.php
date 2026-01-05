<?php
//Forzar tipado stricto
declare(strict_types = 1);

//Incluir el autocargador de composer para las clases e interfaces
include("../../vendor/autoload.php");

use BlogDeNotas\Database\Database;
use BlogDeNotas\Estructuras\UserStructure;

include("../include.php");

$forAllUsers = new UserStructure(database::getConnection());

$user = $forAllUsers->readUserWith("alexanderGmail.com");

$uuid = $user->getUuid();

if($forAllUsers->deleteUserWith($uuid))
{
	echo "User eliminado";

} else 
{
	echo "User no eliminado. ALgo ha fallado";
}

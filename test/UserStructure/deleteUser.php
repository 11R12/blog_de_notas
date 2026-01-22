<?php
//Forzar tipado stricto
declare(strict_types = 1);

//Incluir el autocargador de composer para las clases e interfaces
include("../../vendor/autoload.php");

use BlogDeNotas\Database\Database;
use BlogDeNotas\Estructuras\UserStructure;

include("../include.php");

$forAllUsers = new UserStructure(database::getConnection());


#obtenemos el usuario
$user = $forAllUsers->readUserWith("alexalexGmail.com");

#obtenemos el uuid
$uuid = $user->getUuid();

#eliminamos por uuid
if($forAllUsers->deleteUserWith($uuid))
{
	echo "User eliminado";

} else 
{
	echo "User no eliminado. ALgo ha fallado";
}

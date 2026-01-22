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

#El user agrega su nueva clave (Esto es un pequeño ejemplo de edicion de perfil :/)
$newPass = "www44444444";
$hashPass = hash("md5", $newPass);

$user->setPassword($hashPass);



if($forAllUsers->updateDataUserFor($user))
{
	echo "User Actualizado"; 

} else 
{
	echo "No se pudo actulizar el usuario. Algo ha fallado";
}

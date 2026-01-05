<?php
//Forzar tipado stricto
declare(strict_types = 1);

//Incluir el autocargador de composer para las clases e interfaces
include("../../vendor/autoload.php");

use Ramsey\Uuid\Uuid;
use BlogDeNotas\Database\Database;
use BlogDeNotas\Modelos\User;
use BlogDeNotas\Estructuras\UserStructure;

include("../include.php");



#1. Simulamos entrada de datos de un user
$pass = "123456789";


$uuid = Uuid::uuid4()->getBytes();
$nombre  = "Alexander";
$correo = "melendezGmail.com";
$passHash = hash( "md5", $pass);
$telefono = "123123213";

$user = new User([
	'uuid' => $uuid,
	'correo' => $correo,
	'password' => $passHash,
	'nombre' => $nombre,
	'numero_telefono' => $telefono
]);

$forAllUsers = new UserStructure(database::getConnection());


if($forAllUsers->saveUserWith($user))
{
	echo "User guardado";

} else 
{
	echo "User no guardado. Algo ha fallado";
}










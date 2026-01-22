<?php
//Forzar tipado stricto
declare(strict_types = 1);

//Incluir el autocargador de composer para las clases e interfaces
include("../../vendor/autoload.php");

use BlogDeNotas\Database\Database;
use BlogDeNotas\Estructuras\UserStructure;
use BlogDeNotas\Estructuras\CategoryStructure;


include("../include.php");


$forAllUsers = new UserStructure($conexion);
$allCategorys = new CategoryStructure($conexion);


$user = $forAllUsers->readUserWith("melendezGmail.com");

$allCategorys->createCategory('Nueva categoria..', $user->getUuid());



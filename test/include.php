<?php

//Incluir el autocargador de composer para las clases e interfaces
include("../../vendor/autoload.php");

use BlogDeNotas\Database\Database;


//Datos para iniciar la conexion a la base de datos | NOTA: Esto debe ir en un INI.file
$host = 'localhost';
$db = "blog_notas";
$user = "root";
$pass = "rosbert";
$charset = 'utf8';
$opciones = [
	\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
	\PDO::ATTR_EMULATE_PREPARES => false, 
];


try 
{
	database::initialize($user, $pass, $db, $host, $charset, $opciones);

	echo 'Se inicializado la conexion a la Base de Datos' . PHP_EOL;

	$conexion = database::getConnection();

	echo 'Se obtuvo la instancia de la conexcion a la DB' . PHP_EOL;

}catch(\PDOException | \RuntimeException $e){


	if($e instanceof \PDOException OR $e instanceof \RuntimeException)
	{
		//Si hubo un error al establecer la conexcion a la DB
		if($e instanceof \PDOException)
		{

			echo 'No se puedo establecer conexion con la DB'. $e->getMessage() . PHP_EOL;
		
		}

		//Si no se ha inicializado la conexcion previamente a la base de datos antes de obtenerla
		if($e instanceof \RuntimeException)
		{
	
			echo $e->getMessage() . PHP_EOL;

		}



		echo 'Estimado usuario... A ocurrido un problema. Por favor, ingrese mas tarde o intente nuevamente' . PHP_EOL;

		die();

	}

	if($e instanceof \Exception)
	{

		echo $e->getMessage() . PHP_EOL;

	}
	

}
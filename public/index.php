<?php

include_once '../bootstrap.php';

use BlogDeNotas\Controllers\CategoryController;
use BlogDeNotas\Controllers\UserController;
use BlogDeNotas\Controllers\NoteController;
use BlogDeNotas\Estructuras\UserStructure;
use BlogDeNotas\Estructuras\NoteEstruct;
use BlogDeNotas\Estructuras\CategoryStructure;
use Ramsey\Uuid\Uuid;

$uri = $_GET['url'] ?? 'home'; //variable que "inyecta" el .htaccess 

$uri = explode('/', $uri);

$ind = false;


function validateUuid($uuid): ?String{

	if(Uuid::isValid($uuid)) return $uuid;

	return null; 
}


//notes/all

function deleteSess()
{
	unset($_SESSION['user_uuid']);
	unset($_SESSION['nombre']);
	unset($_SESSION['correo']);
	unset($_SESSION['error_flash']);
	unset($_SESSION['error_uuid']);

	session_destroy();

	header('Location: ' . htmlspecialchars(URL) . "index");

}




if(isset($_POST['close']))
{
	if($_POST['close']) deleteSess();

}


if($uri[0] == "user")
{
	$datosPost = [];

	$userController = new UserController(new UserStructure($connection));

	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		$datosPost = filter_input_array(INPUT_POST, $filtros);
	}

	#Pensar en formas de reemplazar esta logica por algo mas optimo
	if($datosPost === NULL) $datosPost = [];

	if($uri[1] == 'register')
	{
		$userController->registerUser($datosPost);
	}
		
	if($uri[1] == 'login')
	{
		$userController->loginUserWith($datosPost);	
	}
}

//rossbert@gmail.com 123123123
if($uri[0] === "notes")
{
	$NoteController = new NoteController(new NoteEstruct($connection));

	$CategoryController = new CategoryController(new CategoryStructure($connection)); 

	if ($uri[1] == "all") 
	{
		$NoteController->index();

	}

	if($uri[1] == "create")
	{
		
		$NoteController->store($CategoryController);

	}

	if($uri[1] == "note")
	{
		$uuid = filter_input(INPUT_GET, 'id', FILTER_CALLBACK, ['options' => 'validateUuid']);

		$NoteController->show($uuid);

	}

}

if($uri[0] === "categories")
{
	$CategoryController = new CategoryController(new CategoryStructure($connection)); 

	if ($uri[1] == "create") 
	{
		$CategoryController->store();

		
	}

}




?>


<!DOCTYPE <html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<title>BLOG DE NOTAS</title>
		<style>
			body {
				background: silver ;
			}
		</style>
	</head>
	<body>


		<?php if($uri[0] === "index"):?>
			<a href="<?= URL;?>user/register">Registrar</a>
			<a href="<?= URL;?>user/login">Login</a>
		<?php endif;?>


		<?php if(isset($_SESSION['user_uuid'])): ?>
			<form action="<?= htmlspecialchars(URL);?>index" method="POST">
				<input type="hidden" name="close" value="true">
				<input type="submit" value="Cerrar Sesion">
			</form>
		<?php endif;?>
	</body>
</html>
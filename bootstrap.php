<?php
declare(strict_types=1);

if(session_start()){
    $flag = "sesion creada";

} else {
    $flag = "sesion no creada";
}


include_once('vendor/autoload.php');

use BlogDeNotas\Database\Database;
use BlogDeNotas\Config;


define('URL', 'http://localhost/blog_de_notas/public/');
define('ROOT_PATH', __DIR__ . DIRECTORY_SEPARATOR);


try {

    $env = new Config();

} catch (\Exception $e){

    echo "A ocurrido un error al iniciar la app. Intente mas tarde";

    //log
    echo $e->getMessage() . "<br>";
    echo $e->getPrevious();

}



//Datos para iniciar la conexion a la base de datos | NOTA: Esto debe ir en un INI.file
$host = $env->getEnv('DB_HOST');
$db = $env->getEnv('DB_NAME');
$user = $env->getEnv('DB_USER');
$pass = $env->getEnv('DB_PASS');
$charset = $env->getEnv('DB_ENCODE');
$opciones = [
	\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
	\PDO::ATTR_EMULATE_PREPARES => false, 
];


database::initialize($user, $pass, $db, $host, $charset, $opciones);

$connection = database::getConnection();
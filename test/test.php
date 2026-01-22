<?php





//Forzar tipado stricto
declare(strict_types = 1);

//Incluir el autocargador de composer para las clases e interfaces
include("../../vendor/autoload.php");


use Ramsey\Uuid\Uuid;#Libreria Ramsey: #Para crear UUIDs
use Monolog\Handler\StreamHandler;#Libreria Monolog - clase para establecer un manejador
use Monolog\Level;#Libreria Monolg - clase para establecer los niveles de errores que el manejador registrara
use Monolog\Logger;#Libreria Monolog: clase para emplear el manejador
use BlogDeNotas\Database\Database;#clase : conexion a la base de datos
use BlogDeNotas\Modelos\Note;#clase : modelo del dato Note
use BlogDeNotas\Interfaces\InterfazUsuario;#interfaz : metodos que debe implementar las estructuras para el manejo de los datos
use BlogDeNotas\Estructuras\NoteEstruct;#clase : logica SQL para manejar el dato Note


//Ruta al archivo donde se registraran los errores de todos los niveles
$fileLogGeneral = dirname(__DIR__).'\\logs.log';

//Ruta al archivo donde se guardaran todos los errores de nivel error
$fileLogError = dirname(__DIR__).'\\logsErrors.log';

//Stream | handler con la ruta 1
$stream1 = new StreamHandler($fileLogGeneral, Level::Debug);

//Stream | handler con la ruta 2
$stream2 = new StreamHandler($fileLogError, Level::Error);

//Objeto logger para crear los logs
$logger = new Logger('GENERAL ERRORS', [$stream1, $stream2]);


$logger->error('Mensaje para comprobar si los stream han sido bien establecidos');




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

	$logger->info('Se inicializado la conexion a la Base de Datos');

	$conexion = database::getConnection();

	$logger->info('Se obtuvo la instancia de la conexcion a la DB');

}catch(\PDOException | \RuntimeException $e){


	if($e instanceof \PDOException OR $e instanceof \RuntimeException)
	{
		//Si hubo un error al establecer la conexcion a la DB
		if($e instanceof \PDOException)
		{

			$logger->error('No se puedo establecer conexion con la DB', [$e->getMessage()]);
		
		}

		//Si no se ha inicializado la conexcion previamente a la base de datos antes de obtenerla
		if($e instanceof \RuntimeException)
		{
	
			$logger->error($e->getMessage());

		}



		echo 'Estimado usuario... A ocurrido un problema. Por favor, ingrese mas tarde o intente nuevamente';

		die();

	}

	if($e instanceof \Exception)
	{

		$logger->error($e->getMessage());

	}
	

}




//Para insertarn una nota, es necesario tener un UUID de un user al que sera asociada


#Comando sql necesario
$getAllDataUser = 'SELECT uuid FROM usuarios WHERE correo = :correo ';


/////////////////////////////////////////////////
//OPTENIENDO UUID DE UN USER A TRAVEZ DEL CORREO
//////////////////////////////////////////////////


$stmt = $conexion->prepare($getAllDataUser);
$stmt->execute(['correo' => 'rosbert@gmail.com']);
$userData = $stmt->fetch(\PDO::FETCH_ASSOC);


#UUID del USER
$userUuid = $userData['uuid'];






////////////////////////////////////////////////////////////////
//Datos que son necesarios que tenga la nota para ser almacenada
//ES DECIR, los dato necesarios para crear una instancia
////////////////////////////////////////////////////////////////


$uuidNote = Uuid::uuid4(); #De la libreria Ramsey | genera un UUID estandar 4 para la nota a insertar
$noteUuid = $uuidNote->getBytes();
$noteCategoria = '65';
$noteTitulo = 'NUEVO TITULO DE LA NOTA DE PRUEBAAAAAAAAAAAAAAAA';
$noteContenido = 'Contenido de la nota de Prueba';













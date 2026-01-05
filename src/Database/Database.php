<?php


namespace BlogDeNotas\Database; 


#final class, para evitar herencia
final class Database {

	public static ?\PDO $db = null;

	private function __construct(
		string $user, 
		string $pass, 
		string $db,
		string $host,
		?string $charset, 
		?array $op
	){

		//DNS
		$dns = "mysql:host={$host};dbname={$db}";

		#si proporciona una codificacion a usar
		if($charset !== null) $dns .= ";charset={$charset}";

		$args = [$dns, $user, $pass];
 		
 		#si proporciona opciones de conexion a la base de datos
		if($op !== null ) $args[] = $op;

		Database::$db = new \PDO(...$args);
	
		
	} 


	public static function initialize(
		string $user, 
		string $pass, 
		string $db, 
		string $host, 
		?string $charset, 
		?array $op
	): void{

		if(Database::$db !== null) throw new \Exception('La conexion a la DB ya esta establecida');

		new Database($user, $pass, $db, $host, $charset, $op);

	}

	public static function getConnection()
	{

		if(Database::$db === null) throw new \RuntimeException('No se ha inicializado la conexion a la DB');

		return Database::$db;

	} 


	#evitar clonacion de la clase
	public function __clone()
	{
		throw new \ErrorException('No puede clonar esta clase');

	}


	#evitar serializacion de la clase
	public function __serialize()
	{

		return throw new \ErrorException('No puede serializar esta clase');

	}

	#Evitar recreacion del objeto
	public function __wakeup()
	{

		return throw new \ErrorException('No puede recrear el objeto');
		
	}



}








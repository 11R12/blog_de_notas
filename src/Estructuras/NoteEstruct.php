<?php

namespace BlogDeNotas\Estructuras;


use BlogDeNotas\Database\Database; 
use BlogDeNotas\Modelos\Note;	
use BlogDeNotas\Modelos\User;   	 
use BlogDeNotas\Interfaces\InterfaceNote;
use Exception;

class NoteEstruct implements InterfaceNote{


	//COMANDO PARA INSERTAR NOTAS
	private string $insertNoteSql = 'INSERT INTO notas (uuid, usuario_uuid, categoria_id, titulo, contenido) VALUES (:uuid, :usuario_uuid , :categoria_id, :titulo, :contenido)';

	//COMANDO PARA ACTUALIZAR UNA NOA
	private string $updateNoteSql = 'UPDATE notas SET categoria_id = :categoria_id, titulo = :titulo, contenido = :contenido WHERE uuid = :uuid AND usuario_uuid = :usuario_uuid';

	//COMANDO PARA OBTENER LOS DATOS DE UNA NOTA ESPECIFICA BASANDONOS EN SU UUID Y EL UUID DEL USUARIO
	private string $readANoteSql = 'SELECT * FROM notas WHERE id = :id AND usuario_uuid = :usuario_uuid';

	//COMANDO PARA ELIMINAR UNA NOTA ESPECIFICA BASANDONOS EN SU UUID Y EL UUID DEL USUARIO
	private string $deleteANoteSql= 'DELETE FROM notas WHERE uuid = :uuid AND usuario_uuid = :usuario_uuid';

	//COMANDO PARA OPTENER TODAS LA NOTAS PERTENECIENTES A UN USUARIO BASANDONOS EN EL UUID DEL USUARIO
	private string $readAllNotes = 'SELECT * FROM notas WHERE usuario_uuid = :usuario_uuid';

	//MODIFICADOR DE COMANDO PARA ORDENARLAS DE FORMA ASCENDENTE
	private const ORDER_NEW_OLD = ' ORDER BY fecha_creacion ASC';

	//MODIFICADOR DE COMANDO PARA ORDENARLAS DE FORMA DESCENDENTE
	private const ORDER_OLD_NEW = ' ORDER BY fecha_creacion DESC'; 

	//MODIFICADOR DE COMANDO PARA FILTRARLAS POR CATEGORIA
	private const CATEGORY = ' AND categoria_id = :categoria_id';

	//Conexion a la base de datos
	private static ?\PDO $db = null;


	/**
	 * INYECTAR DEPENDENCIA PDO
	 * 
	 * @param Objeto PDO que representa la conexion a la DB
	 * */
	public function __construct(\PDO $db)
	{
		if(!($db instanceof \PDO)) throw new \ErrorException('Se espera una instancia de PDO para obtener la conexcion');

		if(NoteEstruct::$db !== null) throw new \Exception('Ya existe una dependencia inyectada de un objeto PDO');

		NoteEstruct::$db = $db;

	} 


	public static function existsConexion(): bool
	{
		if(NoteEstruct::$db) return true;

		return false;

	}



	public function createNote(Note $nota): bool 
{
    if(!NoteEstruct::existsConexion()) throw new \RuntimeException('No existe conexion establecida con la DB');

    try 
    {
        $stmt = NoteEstruct::$db->prepare($this->insertNoteSql);

        // Vinculamos manualmente para que los UUIDs se envíen como BINARIOS
        $stmt->bindValue(':uuid',         $nota->getUuid(),         \PDO::PARAM_LOB);
        $stmt->bindValue(':usuario_uuid', $nota->getUuidUserReference(), \PDO::PARAM_LOB);
        $stmt->bindValue(':categoria_id', $nota->getCategoriaId(),  \PDO::PARAM_INT);
        $stmt->bindValue(':titulo',       $nota->getTitulo(),       \PDO::PARAM_STR);
        $stmt->bindValue(':contenido',    $nota->getContenido(),    \PDO::PARAM_STR);

        return $stmt->execute();

    } catch (\PDOException $e) 
    {
        // Esto te mostrará el error real de SQL (como el de la categoría)
        throw new \PDOException('No se pudo guardar la nota: ' . $e->getMessage());
    }
}


	
	public function readAllNotes(string $userUuid): array
	{	
		if(!NoteEstruct::existsConexion()) throw new \RuntimeException('No existe conexion establecida con la DB');

		

		try
		{
			$stmt = NoteEstruct::$db->prepare($this->readAllNotes);
			$stmt->execute(['usuario_uuid' => $userUuid]);

		}catch(\PDOException $e)
		{
			throw new \PDOException($e->getMessage());

		}

		$arrayOfNotes = [];

		foreach($stmt->fetchAll(\PDO::FETCH_ASSOC) as $index => $array )
		{

			foreach($array as $propiedad => $valor)
			{

				#guardamos los datos de cada nota en un array para pasar al constructor Note
				$dataToObj[$propiedad] = $valor;	

			}

			#instanciamos, y guardamos el objeto en un nuevo array.
			$arrayOfNotes[] = new Note($dataToObj); 

		}

		

		return $arrayOfNotes;

	}


	
	public function readANote(string $userUuid, string $id): Note
	{
		if(!NoteEstruct::existsConexion()) throw new \RuntimeException('No existe conexion establecida con la DB');

		try
		{

			$stmt = NoteEstruct::$db->prepare($this->readANoteSql);

			$stmt->execute(['id' => $id, 'usuario_uuid' => $userUuid]);

		}catch(\Exception $e)
		{ 

			throw new \PDOException('No se puedo obtener una nota especifica de la base datos');

		}

		return new Note($stmt->fetch(\PDO::FETCH_ASSOC));

	}





	public function updateNote(Note $nota): bool
	{
		if(!NoteEstruct::existsConexion()) throw new \RuntimeException('No existe conexion establecida con la DB');

		try
		{

			$stmt = NoteEstruct::$db->prepare($this->updateNoteSql);

			$stmt->execute($nota->dataUpdateToArray());

		} catch(\PDOException $e)
		{

			throw new \PDOException('No se pudo actualizar el contenido de la nota en la base de datos');

		}

		return true;

	}


	


	public function deleteNote(string $userUuid, string $noteUuid): bool
	{
		if(!NoteEstruct::existsConexion()) throw new \RuntimeException('No existe conexion establecida con la DB');

		try
		{

			$stmt = NoteEstruct::$db->prepare($this->deleteANoteSql);

			$stmt->execute(['uuid' => $noteUuid, 'usuario_uuid' => $userUuid]);


		}catch(\PDOException)
		{ 

			throw new \PDOException('No se puedo ELIMINAR una nota especifica de la base datos');

		}

		return true;
		
	}


	


	#obtener las notas de un usuario ordenadas por New -> OLD | OLD -> NEW
	public function filterCreationDate(string $userUuid, bool $optionOrder = false): array
	{
		if(!NoteEstruct::existsConexion()) throw new \RuntimeException('No existe conexion establecida con la DB');

		if ($optionOrder === true) $optionOrder = self::ORDER_NEW_OLD;

		if ($optionOrder === false) $optionOrder = self::ORDER_OLD_NEW; 

		try
		{

			$stmt = NoteEstruct::$db->prepare($this->readAllNotes . $optionOrder);
			$stmt->execute(['usuario_uuid' => $userUuid]);

		}catch(\PDOException $e)
		{
			throw new \PDOException('No se pudieron leer todas las notas de un usuario ordernadas por fecha: ');

		}


		foreach($stmt->fetchAll(\PDO::FETCH_ASSOC) as $index => $array )
		{
			$dataToObj = [];

			foreach($array as $propiedad => $valor)
			{

				$dataToObj[$propiedad] = $valor;	

			}

			$arrayOfNotes[] = new Note($dataToObj); 

		}

		return $arrayOfNotes;

	}



	#obtener las notas del usuario de una categoria especifica
	public function filterCategory(string $userUuid, int $categoria): array
	{
		if(!NoteEstruct::existsConexion()) throw new \RuntimeException('No existe conexion establecida con la DB');

		$arrayOfNotes = [];

		try
		{

			$stmt = NoteEstruct::$db->prepare($this->readAllNotes . self::CATEGORY);
			$stmt->execute(['usuario_uuid' => $userUuid, 'categoria_id' => $categoria]);

		}catch(\PDOException)
		{
			throw new \PDOException('No se pudieron leer todas las notas de un usuario ordenadas por categoria');

		}


		foreach($stmt->fetchAll(\PDO::FETCH_ASSOC) as $index => $array )
		{
			$dataToObj = [];

			foreach($array as $propiedad => $valor)
			{

				$dataToObj[$propiedad] = $valor;	

			}

			$arrayOfNotes[] = new Note($dataToObj); 

		}

		return $arrayOfNotes;

	}

	
	#obtener las notas del usuario de una categoria especifica desde New -> OLD | OLD -> NEW
	public function filterCategoryAndCrationDate(string $userUuid, int $categoria, bool $optionOrder = false): array 
	{
		if(!NoteEstruct::existsConexion()) throw new \RuntimeException('No existe conexion establecida con la DB');

		if ($optionOrder === true) $optionOrder = self::ORDER_NEW_OLD;

		if ($optionOrder === false) $optionOrder = self::ORDER_OLD_NEW; 

		try
		{

			$stmt = NoteEstruct::$db->prepare($this->readAllNotes . self::CATEGORY . $optionOrder);
			$stmt->execute(['usuario_uuid' => $userUuid, 'categoria_id' => $categoria]);

		}catch(\PDOException)
		{
			throw new \PDOException('No se pudieron leer todas las notas de un usuario ordenadas por categoria y fecha');

		}


		foreach($stmt->fetchAll(\PDO::FETCH_ASSOC) as $index => $array )
		{
			$dataToObj = [];

			foreach($array as $propiedad => $valor)
			{

				$dataToObj[$propiedad] = $valor;	

			}

			$arrayOfNotes[] = new Note($dataToObj); 

		}

		return $arrayOfNotes;

	}

}


















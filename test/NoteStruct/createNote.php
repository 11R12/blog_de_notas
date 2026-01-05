<?php
//Forzar tipado stricto
declare(strict_types = 1);

//Incluir el autocargador de composer para las clases e interfaces
include("../../vendor/autoload.php");


use Ramsey\Uuid\Uuid;
use BlogDeNotas\Database\Database;
use BlogDeNotas\Modelos\Note;
use BlogDeNotas\Estructuras\NoteEstruct;
use BlogDeNotas\Estructuras\UserStructure;

include("../include.php");


$forAllUsers = new UserStructure(database::getConnection());
$allNotes = new NoteEstruct(Database::getConnection()); //Puede ser una falsa que almacene en TXT

#1. La nostas necesitan estar asociadas a un user por eso debemos obtener el UUID de uno
$userUuid = $forAllUsers->readUserWith('melendezGmail.com')->getUuid(); 

#2. Debemos asignarle a la nota un UUID
$noteUuid = Uuid::uuid4()->getBytes();

#3. Simulamos el envio de datos por parte del usuario

//Debe ser el id de una categoria existente
//Debemos obtner las categorias de cada user asociados a su UUID en el home->input->SELECT 
$noteCategoria = '10'; 
$noteTitulo = 'Nota categoria 4';
$noteContenido = 'Contenido de la nota de Prueba';

#4. Creamos el Objeto Note a partir de esos datos
$objNote = new Note([

	'uuid' => $noteUuid,
	'usuario_uuid' => $userUuid,
	'categoria_id' => $noteCategoria,
	'titulo' => $noteTitulo,
	'contenido' => $noteContenido
 
]);


try {
#5. Probamos la funcionalidad CREAR NOTA
if($allNotes->createNote($objNote))
{

	echo "Una nota ha sido creada" .  PHP_EOL;

} else {

	throw new \ErrorException('Fallo crear nota');

} 

} catch (\PDOException $e){
	echo $e->getMessage();
	echo $e->getTrace();
}

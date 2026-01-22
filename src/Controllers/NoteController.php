<?php

namespace BlogDeNotas\Controllers;

use BlogDeNotas\Controllers\CategoryController;
use BlogDeNotas\Estructuras\CategoryStructure;
use BlogDeNotas\Estructuras\NoteEstruct;
use BlogDeNotas\Modelos\Note;
use Ramsey\Uuid\Uuid;
use Exception;

class NoteController {

    private NoteEstruct $noteService;

    public function __construct(NoteEstruct $noteService) {
        $this->noteService = $noteService;
    }

    /**
     * Muestra la lista de notas del usuario actual
     */
    public function index() {
        try {
            // Suponiendo que el UUID del usuario está en la sesión
            $userUuid = $_SESSION['user_uuid'] ?? null;

            if($userUuid == Null){

              throw new Exception('No existe la UUID del user | Vista allnotes | method index'); 

            } 
            
            //if (!$userUuid) {
                
              //  header('Location: '. URL . 'user/login');
                //exit;
            //}

            // Podrías capturar filtros desde $_GET
            //$category = $_GET['category'] ?? null;
            //$order = isset($_GET['order']) && $_GET['order'] === 'asc';

            
            $notes = $this->noteService->readAllNotes(Uuid::fromString($userUuid)->getBytes());

            // Cargar la vista y pasarle las notas
            require ROOT_PATH . "src/views/allnotes.php";

        } catch (Exception $e) {
            echo $e->getMessage();
            require ROOT_PATH . "src/views/error.php";
        }
    }

    /**
     * Procesa la creación de una nueva nota
     */
    public function store(CategoryController $CategoryController) 
    {

        $categories =  $CategoryController->index();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST')
        { 
            require ROOT_PATH . 'src/views/noteCreate.php';

            return;
        }
        

        try {
            // Creamos el modelo Note con los datos del POST
            // Nota: El modelo Note debería encargarse de generar su propio UUID si es nuevo
            $data = [
                'usuario_uuid' => $_SESSION['user_uuid'],
                'categoria_id' => $_POST['categoria_id'],
                'titulo'       => $_POST['titulo'],
                'contenido'    => $_POST['contenido'],
            ];

            $nuevaNota = new Note($data, true);

            $exito = $this->noteService->createNote($nuevaNota);

            if ($exito) 
            {
                header('Location: '. htmlspecialchars(URL) . 'notes/all?msg=created');
                exit();
            }

        } catch (Exception $e) 
        {
            $errorN = "Error al crear nota: " . $e->getMessage();
            
        //Nota: debo reconsiderar este finally. Refactorizando esta parte olvide el porque la habia colocado XD. 
        } finally 
        {
            require ROOT_PATH . 'src/views/noteCreate.php';

        }

        
    }

    /**
     * Muestra una nota específica
     */
    public function show(string $uuid) {
        try 
        {
            if($uuid === Null) throw new \Exception("Nota especifica a visualizar inexistente");

            $userUuid = $_SESSION['user_uuid'];
            $note = $this->noteService->readANote($userUuid, $uuid);
            
            require_once htmlspecialchars(ROOT_PATH) . 'src/views/view_a_note.php';

        } catch (Exception $e) 
        {
      
            // header('Location:'. htmlspecialchars(URL) .'/notas?error=not_found');
        }
    }

    /**
     * Elimina una nota
     */
    public function delete($uuid) {
        try {

            $userUuid = $_SESSION['user_uuid'];
            $this->noteService->deleteNote($userUuid, $uuid);
                
                header('Location: /notas?msg=deleted');

        } catch (Exception $e) {

            header('Location: /notas?error=cant_delete');

        }
    }
}
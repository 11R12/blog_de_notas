<?php

namespace BlogDeNotas\Controllers;

use BlogDeNotas\Estructuras\CategoryStructure;
use Ramsey\Uuid\Uuid;
use Exception;

class CategoryController 
{
    private CategoryStructure $categoryService;

    public function __construct(CategoryStructure $categoryService) 
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Lista todas las categorías del usuario
     */
    public function index():?array 
    {
        try {
            // Verificamos sesión (esto podría moverlo a un middleware o método privado)

        
            $userUuid = Uuid::fromString($_SESSION['user_uuid'])->getBytes(); //Responsabilizar a la AbsSQL :(
           

            if (!$userUuid) 
            {
                header('Location: http://localhost/blog_de_notas/public/user/login');
                exit;
            }

            $categories = $this->categoryService->readCategorys($userUuid);

        } catch (Exception $e) {
            $error = $e->getMessage(); //mejorar
            require_once ROOT_PATH . 'src/views/error.php';
        } finally 
        {
            return $categories;

        }

        
    }

    /**
     * Procesa el formulario de creación de categoría
     */
    public function store() 
    {
        include_once ROOT_PATH . 'src/views/categorieCreate.php';

        if ($_SERVER['REQUEST_METHOD'] !== 'POST')
        {
            //header('Location: ' . URL . 'categories/create');
            return;
        }

        try {
            $userUuid = $_SESSION['user_uuid'] ?? null;
            $nombre = trim($_POST['nombre_categoria'] ?? '');

            if (empty($nombre)) {
                throw new Exception("El nombre de la categoría es obligatorio.");
            }

            if($userUuid == Null)
            {
                throw new Exception("Falta el UUID del USER para CREAR la CATEGORIA");

            }

            $userUuid = Uuid::fromString($userUuid)->getBytes(); //Responsabilizar a la AbsSQL
                        

            $exito = $this->categoryService->createCategory($nombre, $userUuid);

            session_regenerate_id();

            if ($exito) {
                // Redirigir para evitar reenvío de formulario al recargar (Post-Redirect-Get)
                header('Location: http://localhost/blog_de_notas/public/categories/create?msg=success');
                exit;
            }

        } catch (Exception $e) {
            // Aquí podrías guardar el error en sesión para mostrarlo tras la redirección
            $_SESSION['error_flash'] = $e->getMessage();
            $_SESSION['error_uuid'] = $userUuid;
            header('Location: http://localhost/blog_de_notas/public/categories/create?msg=error');
            exit;
        }
    }





    /**
     * Elimina una categoría
     * @param string|int $id ID de la categoría
     */
    public function destroy($id) 
    {
        try {
            $userUuid = $_SESSION['user_uuid'] ?? null;

            if (!$userUuid) throw new Exception("Sesión no válida.");

            $this->categoryService->deleteCategory((string)$id, $userUuid);
            
            header('Location: http://localhost/blog_de_notas/public/categories?msg=deleted');
            exit;

        } catch (Exception $e) {
            $_SESSION['error_flash'] = $e->getMessage();
            header('Location: http://localhost/blog_de_notas/public/categories?msg=error_delete');
            exit;
        }
    }
}
<?php


namespace BlogDeNotas\Controllers;

use BlogDeNotas\Estructuras\UserStructure;
use BlogDeNotas\Modelos\User;

use Ramsey\Uuid\Uuid;

class UserController
{
    #Abstraccion a la DB
    private UserStructure $userRepo;

    public function __construct(UserStructure $userRepo)
    {
        $this->userRepo = $userRepo;
    }




    #Registrar usuario
    public function registerUser(array $data = []): void
    {
        if(!empty($data)){

            if(!in_array(false, $data, true)){

                $user = new User($data);

                if($this->userRepo->saveUserWith($user)){
                    //return require ROOT_PATH . "src/views/login.php";
                    header('Location: http://localhost/blog_de_notas/public/user/login');
                    exit();
                    
                }
            }
        }

        require ROOT_PATH . "src/views/register.php";
        return;
        
    }




    #Logear usuario
    public function loginUserWith(array $data = []): void
    {
        if(!count($data) == 0)
        {
            if($data['correo'] !== Null AND $data['password'] !== Null)
            {
                if($this->userRepo->loginUserWith($data['correo'], $data['password']))
                {

                    $user = $this->getUserInfo($data['correo']);
                    
                    $_SESSION['correo'] = $user->getCorreo();
                    $_SESSION['user_uuid'] = Uuid::fromBytes($user->getUuid())->toString();
                    $_SESSION['nombre'] = $user->getNombre();

                    session_regenerate_id();

                    session_write_close();

                    header('Location: http://localhost/blog_de_notas/public/notes/all?');
                    exit();
                }
            }
        }

        require ROOT_PATH . "src/views/login.php";
        return;
    }




    #Obtener la informacion de un usuario
    public function getUserInfo(string $correo): ?User
    {
        // Obtener un usuario del repositorio
        return $this->userRepo->readUserWith($correo);
    }




    #Actualizar los datos de un  usuario
    public function updateUser(User $user): bool
    {
        // Actualizar el usuario con el repositorio
        return $this->userRepo->updateDataUserFor($user);
    }
}

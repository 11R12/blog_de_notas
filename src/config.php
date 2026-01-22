<?php 
// src/Config.php

namespace BlogDeNotas;

use Dotenv\Dotenv;

final class Config
{
    private $dotenv;

    public function __construct()
    {
        if($this->dotenv !== null) throw new \Exception('Ya existe una instancia de acceso');

        // Cargar el archivo .env desde la raíz
        $this->dotenv = Dotenv::createImmutable(__DIR__ . '/../'); // Rutas relativas

        try {

            $this->dotenv->load();

        } catch (\Exception $e){

            throw new \Exception('Las credenciales no fueron cargadas','', $e);

        }
        
    }

    // Método para obtener el valor de una variable de entorno
    public function getEnv($key, $default = null)
    {
        return $_ENV[$key] ?: $default;
    }
}
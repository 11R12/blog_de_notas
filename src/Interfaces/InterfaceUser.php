<?php

Namespace BlogDeNotas\Interfaces;

use BlogDeNotas\Modelos\User;



interface InterfaceUser{

	#Guardar usuario | Correo | Contraseña | Uuid
	public function saveUserWith(User $user): bool;

	#obtener los datos de un user
	public function readUserWith(string $correo): User;

	#Actualizar los datos de un usuario
	public function updateDataUserFor(User $user): bool;

	#eliminar usuario
	public function deleteUserWith(string $uuid): bool;

}
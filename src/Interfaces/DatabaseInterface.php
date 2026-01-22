<?php

namespace BlogDeNotas\Interfaces;

interface DatabaseInterface{

	public function saveUser(string $sql, array $data): bool;

	public function readUser(string $sql, string $data): array;

	public function updateUser(string $sql, array $data): bool;
	
	public function deleteUser(string $sql, string $data): bool;

	public function existsEmailInDb(string $sql, string $correo): bool;

	public function getPasswordOfUser(string $sql, string $correo): string;

} 
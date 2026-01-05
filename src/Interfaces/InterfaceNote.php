<?php
namespace BlogDeNotas\Interfaces;

use BlogDeNotas\Modelos\Note;
use BlogDeNotas\Modelos\User;

interface InterfaceNote{

	/**
	 * @return Boolean para validar si se ha creado la nota
	 */
	public function createNote(Note $nota): bool;

	/**
	 * @return Un array de objetos/instancias de Note
	 */
	public function readAllNotes(string $userUuid): array; //array de objetos

	/**
	 * @return Un objeto/instancia de Note
	 */
	public function readANote(string $userUuid, string $id): Note;

	/**
	 * @return Bolean para validar si ha sido actualizada la nota
	 */
	public function updateNote(Note $nota): bool;

	/**
	 * @return Bolean para validar si ha sido eliminada la nota
	 */
	public function deleteNote(string $userUuid, string $noteUuid): bool;
	
	/**
	 * @return Un array de objetos Note ordenados por fecha de forma ASC o DESC
	 */
	public function filterCreationDate(string $userUuid, bool $optionOrder = false): array;

	/**
	 * @return Un array de objetos Note
	 */
	public function filterCategory(string $userUuid, int $categoria): array;
	
	/**
	 * @return Un array de objetos Note
	 */
	public function filterCategoryAndCrationDate(string $userUuid, int $categoria, bool $optionOrder = false): array; 
	
}

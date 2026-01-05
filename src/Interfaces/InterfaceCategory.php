<?php

namespace BlogDeNotas\Interfaces;

use BlogDeNotas\Modelos\Category;

interface InterfaceCategory
{

	public function createCategory(string $nombre, string $uuidUser): bool;

	public function readCategorys(string $uuidUser): array;

	public function deleteCategory(string $id, string $uuidUser): bool;

}
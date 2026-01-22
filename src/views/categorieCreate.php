<?php 
	if(isset($_SESSION['error_flash'])): 
		echo "<h3>ERROR</h3>";
		echo $_SESSION['error_flash'];
		echo "<h3>ID</h3>";
		echo $_SESSION['error_uuid'];
	endif; 
?>

<form action="<?= htmlspecialchars(URL)?>categories/create" method="POST">
	<input type="text" name="nombre_categoria">
	<input type="submit" value="CREAR">
</form>

<a href="<?= htmlspecialchars(URL)?>notes/all">Regresar</a>
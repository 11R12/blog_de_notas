
<form action="<?= htmlspecialchars(URL) ?>notes/create" method="POST">
	<input name="titulo" type="text" placeholder="Titulo">
	<select name="categoria_id">
		<option value="1">Sin Categoria</option>
		<?php
			if($categories):
				foreach ($categories as $i => $categorie):
		 			echo "<option value=\"{$categorie->getId()}\">{$categorie->getNombre()}</option>";
				endforeach;
			endif;
		?>
	</select>
	<input name="contenido" type="text" placeholder="Contenido...">
	<input type="submit" value="Crear nota">
</form>

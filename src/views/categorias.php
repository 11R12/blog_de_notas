

<form action="<?= htmlspecialchars(URL)?>notes/all" method="POST">
	<select name="categorie">
		<option value="Sin Categoria">Sin Categoria</option>
		<?php
			if($categories):
				foreach ($categories as $i => $categorie):
		 			echo "<option value={$categorie->getName}>{$categorie->getName}</option>";
				endforeach;
			endif;
		?>
	</select>
</form>


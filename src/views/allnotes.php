<div>
	<a href="<?= htmlspecialchars(URL)?>categories/create">Crear Una Categoria</a>
	<a href="<?= htmlspecialchars(URL)?>notes/create">Crear Una Nota</a>
</div>

<ul>
	<?php
		if($notes):
			foreach($notes as $i => $note):
				echo "<li><a href=\"". htmlspecialchars(URL) . "notes/note?id={$note->getUuid()}\">" . $note->getTitulo() . "</a></li>" ;
			endforeach;
		endif;
	?>
</ul>
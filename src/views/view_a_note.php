<?php 
if(isset($note) AND is_object($note))
{

	$titulo = $note->getTitulo();
	$categoria = $note->getCategoriaId();
	$fechaCreacion = $note->getFechaDeCreacion();
	$contenido = mb_str_split($note->getContenido());


} else {

	echo "Error al cargar la nota. Intente de nuevo. Si el error persiste intente mas tarde, gracias...";

};
?>

<div class="note-view-box">
	<section>
		<div><?= $titulo; ?></div>
		<div><?= $categoria; ?></div>
		<div><?= $fechaCreacion; ?></div>
	</section>
	<section class="note-content" >
		<p>
			<?php 
				foreach($contenido as $letra){
					echo $letra;
				}
			?>
		</p>
	</section>
</div>
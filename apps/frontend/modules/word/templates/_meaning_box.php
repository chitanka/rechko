<div class="meaning box">
	<h3>Значение <?php echo link_to_edit_meaning($word, $sf_user) ?></h3>
	<div id="meaning_<?php echo $word['id'] ?>" class="data">
		<?php include_partial('meaning', array('word' => $word)) ?>
	</div>
</div>
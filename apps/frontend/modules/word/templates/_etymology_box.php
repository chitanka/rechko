<?php if ($word['etymology'] || $sf_user->isEditor()): ?>
	<div class="etymology box">
		<h3>Етимология <?php echo link_to_edit_etymology($word, $sf_user) ?></h3>
		<div id="etymology_<?php echo $word['id'] ?>" class="data">
			<?php include_partial('etymology', array('word' => $word)) ?>
		</div>
	</div>
<?php endif ?>

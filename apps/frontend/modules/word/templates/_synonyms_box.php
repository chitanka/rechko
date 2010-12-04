<?php if ($word['synonyms'] || $sf_user->isEditor()): ?>
	<div class="synonyms box">
		<h3>Синоними <?php echo link_to_edit_synonyms($word, $sf_user) ?></h3>
		<div id="synonyms_<?php echo $word['id'] ?>" class="data">
			<?php include_partial('synonyms', array('word' => $word)) ?>
		</div>
	</div>
<?php endif ?>

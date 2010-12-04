<?php if ($word['other_langs'] || $sf_user->isEditor()): ?>
	<div class="translations box">
		<h3>Превод</h3>
		<div id="translations_<?php echo $word['id'] ?>" class="data">
			<?php include_partial('translations', array('word' => $word)) ?>
		</div>
	</div>
<?php endif ?>

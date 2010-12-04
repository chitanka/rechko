<?php foreach ($words as $i => $word): ?>
	<div id="word_<?php echo $word['id'] ?>" class="box">
	<h2>
		<?php if ($count > 1): ?>
			<?php echo ($i+1) ?>.
		<?php endif ?>
		<?php include_partial('word_header', array('word' => $word)) ?>
		<?php echo link_to_delete_word($word, $sf_user) ?>
		<?php echo link_to_edit_fake($sf_user) ?>
	</h2>
	<?php include_partial('word', array('word' => $word)) ?>
	</div>
<?php endforeach ?>

<dl>
<?php if ($word['other_langs']): ?>
	<?php foreach (explode(' ', trim($word['other_langs'])) as $lang): ?>
		<dt>
			<?php echo link_to_translation($word, $lang) ?>
		</dt>
		<dd></dd>
	<?php endforeach ?>
<?php endif ?>
</dl>
<?php echo link_to_new_translation($word, $sf_user) ?>

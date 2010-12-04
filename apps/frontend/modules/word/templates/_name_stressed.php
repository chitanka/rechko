<?php if ($word['name_stressed']): ?>
	<?php echo format_stress($word['name_stressed']) ?>
<?php else: ?>
	<?php echo format_stress($word['name']) ?>
<?php endif ?>

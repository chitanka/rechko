<span id="name-stressed_<?php echo $word['id'] ?>">
	<?php include_partial('name_stressed', array('word' => $word)) ?>
</span>
<?php echo link_to_edit_name_stressed($word, $sf_user) ?>
 —
<span id="type_<?php echo $word['id'] ?>">
	<?php include_partial('type', array('word' => $word)) ?>
</span>
<?php echo link_to_edit_type($word, $sf_user) ?>

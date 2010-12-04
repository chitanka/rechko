<h2>
	<?php include_partial('word_header', array('word' => $word)) ?>
	<?php echo link_to_delete_word($word, $sf_user) ?>
</h2>
<?php include_partial('word', array('word' => $word)) ?>

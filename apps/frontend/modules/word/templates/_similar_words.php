<?php use_helper('I18N') ?>
<div class="similar-words box">
	<div class="data">
	<p>Все пак имате късмет.
		<?php echo format_number_choice('[1]Беше открита следната подобна дума|(1,+Inf]Бяха открити следните подобни думи', array(), count($similar_words)) ?>:
	</p>
	<ul>
	<?php foreach ($similar_words as $similar_word): ?>
		<li><?php echo link_to_word($similar_word) ?></li>
	<?php endforeach ?>
	</ul>
	</div>
</div>

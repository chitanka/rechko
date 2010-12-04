<?php if (count($word['IncorrectForms']) || $sf_user->isEditor()): ?>
	<div class="incorrect-forms box">
		<h3>Грешни изписвания (<?php echo count($word['IncorrectForms']) ?>)</h3>
		<div class="data">
			<ul>
				<?php foreach ($word['IncorrectForms'] as $form): ?>
					<?php include_partial('incorrect_form', array('form' => $form)) ?>
				<?php endforeach ?>
			</ul>
			<?php echo link_to_new_incorrect_form($word, $sf_user) ?>
		</div>
	</div>
<?php endif ?>

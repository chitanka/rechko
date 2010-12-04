<?php echo form_tag('@translation_create', array('class' => 'new-form')) ?>
	<div>
		<?php echo $form['name']->render() ?>
		<?php echo $form->renderHiddenFields() ?>
	</div>
	<?php include_partial('edit_form_buttons') ?>
</form>
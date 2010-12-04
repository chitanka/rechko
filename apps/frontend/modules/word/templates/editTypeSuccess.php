<?php echo form_tag_for($form, '@type', array('class' => 'edit-form')) ?>
	<div>
		<?php echo $form['type_id']->render() ?>
		<?php echo $form->renderHiddenFields() ?>
		<?php include_partial('edit_form_buttons') ?>
	</div>
</form>
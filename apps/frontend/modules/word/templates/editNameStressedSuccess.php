<?php echo form_tag_for($form, '@name_stressed', array('class' => 'edit-form')) ?>
	<div>
		<?php echo $form['name_stressed']->render() ?>
		<?php echo $form->renderHiddenFields() ?>
		<?php include_partial('edit_form_buttons') ?>
	</div>
</form>
<?php echo form_tag_for($form, '@meaning', array('class' => 'edit-form')) ?>
	<div class="data">
		<?php echo $form['meaning']->render() ?>
		<?php echo $form->renderHiddenFields() ?>
		<?php include_partial('edit_form_buttons') ?>
	</div>
</form>
<?php echo form_tag_for($form, '@etymology', array('class' => 'edit-form')) ?>
	<div class="data">
		<?php echo $form['etymology']->render() ?>
		<?php echo $form->renderHiddenFields() ?>
		<?php include_partial('edit_form_buttons') ?>
	</div>
</form>
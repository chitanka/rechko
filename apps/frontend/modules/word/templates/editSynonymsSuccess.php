<?php echo form_tag_for($form, '@synonyms', array('class' => 'edit-form')) ?>
	<div class="data">
		<?php echo $form['synonyms']->render() ?>
		<?php echo $form->renderHiddenFields() ?>
		<?php include_partial('edit_form_buttons') ?>
	</div>
</form>
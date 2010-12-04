<?php echo form_tag('@signin') ?>
	<div class="box">
		<?php echo $form['openid']->renderLabel() ?>
		<?php echo $form['openid']->render() ?>
		<button type="submit">Влизане</button>
		<?php echo $form->renderHiddenFields() ?>
	</div>
</form>

<?php echo form_tag('@signin') ?>
	<div class="box">
		<button type="submit">Влизане през <?php echo image_tag('google', array('alt' => 'Google')) ?></button>
		<?php echo $form->renderHiddenFields() ?>
	</div>
</form>

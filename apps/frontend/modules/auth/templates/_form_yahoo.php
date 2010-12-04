<?php echo form_tag('@signin') ?>
	<div class="box">
		<button type="submit">Влизане през <?php echo image_tag('yahoo', array('alt' => 'Yahoo!')) ?></button>
		<?php echo $form->renderHiddenFields() ?>
	</div>
</form>

<?php slot('title', 'Добавяне на дума') ?>
<?php echo form_tag_for($form, '@word', array('class' => 'edit-form')) ?>
	<table>
		<?php echo $form ?>
		<tr>
			<td></td>
			<td><?php include_partial('edit_form_buttons') ?></td>
		</tr>
	</table>
</form>
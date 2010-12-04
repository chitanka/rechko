<?php slot('title', sfConfig::get('app_feedback_title', 'Feedback')) ?>

<?php include_partial('header') ?>

<?php echo form_tag('@feedback') ?>
 <table>
  <?php echo $form['message']->renderRow() ?>
  <?php echo $form['name']->renderRow() ?>
  <?php echo $form['email']->renderRow() ?>
  <tr>
   <td></td>
   <td><button type="submit"><?php echo sfConfig::get('app_feedback_button', 'Send') ?></button></td>
  </tr>
 </table>
</form>

<?php include_partial('footer') ?>


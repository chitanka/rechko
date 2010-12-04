<?php use_helper('JavascriptBase') ?>

<?php echo form_tag('@word', array('method' => 'get', 'onsubmit' => 'return sfSearch.redirect(this)')) ?>
 <div id="search" class="search" title="<?php echo 'Претърсване на речника' ?>">
   <?php echo $form['q']->renderLabel() ?>
   <?php echo $form['q']->render(array('tabindex' => 1)) ?>
   <button type="submit">Търсене</button>
 </div>
</form>

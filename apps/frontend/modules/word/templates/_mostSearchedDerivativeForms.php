<div class="most-searched box">
 <h2>Най-търсени словоформи</h2>
 <div class="data">
 <ul>
  <?php foreach ($forms as $form): ?>
   <li><?php echo link_to_word($form, null, false) ?> (<?php echo $form['search_count'] ?>)</li>
  <?php endforeach ?>
 </ul>
 </div>
</div>

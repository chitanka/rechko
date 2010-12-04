<div class="box">
 <?php foreach ($forms as $i => $form): ?>
  <h2>
   <?php echo ($words_count + $i + 1) ?>.
   <?php echo $form['name'] ?> —
   <?php echo format_deriv_form_desc($form['description']) ?>
  </h2>
  <div class="meaning box">
   <p class="data"><strong class="derivative"><?php echo $form['name'] ?></strong>
    е производна форма
    на <?php echo link_to_word($form['BaseWord']) ?>
    (<?php echo format_deriv_form_desc($form['description']) ?>).</p>
  </div>
 <?php endforeach ?>
</div>
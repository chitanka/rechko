 <?php foreach ($forms as $form): ?>
  <p><span class="incorrect"><?php echo $form['name'] ?></span> е грешно изписване на <?php echo link_to_word($form['CorrectWord']) ?>.</p>
 <?php endforeach ?>

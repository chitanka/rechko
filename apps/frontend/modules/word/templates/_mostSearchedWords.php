<div class="most-searched box">
 <h2>Най-търсени думи</h2>
 <div class="data">
 <ul>
  <?php foreach ($words as $word): ?>
   <li><?php echo link_to_word($word, null, false) ?> (<?php echo $word['search_count'] ?>)</li>
  <?php endforeach ?>
 </ul>
 </data>
</div>

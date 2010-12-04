<?php if ($pager->haveToPaginate()): ?>
 <div class="pagination">
  <ul>
   <li><?php echo link_to('|&lt;', $route) ?></li>

   <li><?php echo link_to('&lt;', $route.'&page='.$pager->getPreviousPage()) ?></li>

   <?php foreach ($pager->getLinks() as $page): ?>
    <?php if ($page == $pager->getPage()): ?>
     <li><a class="current"><?php echo $page ?></a></li>
    <?php else: ?>
     <li><?php echo link_to($page, $route.'&page='.$page) ?></li>
    <?php endif ?>
   <?php endforeach ?>

   <li><?php echo link_to('&gt;', $route.'&page='.$pager->getNextPage()) ?></li>

   <li><?php echo link_to('&gt;|', $route.'&page='.$pager->getLastPage()) ?></li>
  </ul>
 </div>
<?php endif ?>

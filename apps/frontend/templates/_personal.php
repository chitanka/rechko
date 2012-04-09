<div id="personal">
	<ul>
	<?php if ($sf_user->isAuthenticated()): ?>
		<li class="profile"><?php echo link_to($sf_user->getRealname(), '@user?slug='.$sf_user->getGuardUser()->getSlug()) ?></li>
		<li class="signout"><?php echo link_to('Изход', '@signout') ?></li>
	<?php else: ?>
		<li class="signin"><?php echo link_to('Вход', '@signin') ?></li>
	<?php endif ?>
	</ul>
</div>

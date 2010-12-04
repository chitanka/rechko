<?php slot('title', 'Грешка при влизането с OpenID') ?>
<div class="error">
	<?php if ($sf_user->hasFlash('openid_error')): ?>
		<?php echo $sf_user->getFlash('openid_error') ?>
	<?php endif ?>
</div>

<p>Опитайте пак. Може да е временен проблем.</p>
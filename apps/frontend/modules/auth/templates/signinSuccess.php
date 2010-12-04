<?php slot('title', 'Вход чрез OpenID') ?>

<p>Оттук може да влезете в речника като регистриран потребител. Единственото, което е нужно, е да разполагате с <a href="#openid-info">OpenID</a>.</p>

<div id="signin-box">
	<?php include_partial('form_openid', array('form' => $form)) ?>
	<p>или</p>
	<div id="openid-custom">
		<?php include_partial('form_google', array('form' => $google_form)) ?>
		или
		<?php include_partial('form_yahoo', array('form' => $yahoo_form)) ?>
	</div>
</div>

<?php if ($redirect): ?>
	<?php if ($redirect['success']): ?>
		<?php echo $redirect->getRaw('htmlCode') ?>
	<?php else: ?>
		<div class="error"><?php echo $redirect['error'] ?></div>
	<?php endif ?>
<?php endif ?>

<div id="openid-info">
	<?php include_partial('about_openid') ?>
</div>
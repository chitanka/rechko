<?php if (count($word['DerivativeForms'])): ?>
	<div class="derivative-forms box">
	<h3>Словоформи</h3>
		<div class="data">
			<p>С дефиси (къси тирета) са показани възможностите за сричкопренасяне.</p>
			<?php include_partial_forms($word, $sf_user) ?>
		</div>
	</div>
<?php endif ?>

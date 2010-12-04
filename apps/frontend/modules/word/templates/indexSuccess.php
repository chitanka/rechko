<?php slot('header', get_partial('search_with_random')) ?>

<?php if ( ! $query): ?>
	<?php slot('title', '…') ?>
<?php else: ?>

	<?php slot('title', $query) ?>

	<?php if ($no_results): ?>

		<p class="no-items"><?php echo 'Търсената дума липсва в речника.' ?></p>

		<?php if (count($similar_words)): ?>
			<?php include_partial('similar_words', array('similar_words' => $similar_words)) ?>
		<?php endif ?>

	<?php else: ?>

		<?php if ($words_count): ?>
			<?php include_partial('words', array('words' => $words, 'count' => $words_count + $derivative_forms_count)) ?>
		<?php endif ?>

		<?php if ($derivative_forms_count): ?>
			<?php include_partial('derivative_forms_with_links', array('forms' => $derivative_forms, 'count' => $derivative_forms_count, 'words_count' => $words_count)) ?>
		<?php endif ?>

		<?php if ($incorrect_forms_count): ?>
			<?php include_partial('incorrect_forms_with_links', array('forms' => $incorrect_forms)) ?>
		<?php endif ?>

		<?php if ($words_count): ?>
			<?php //include_partial('statistics', array('word' => $words[0])) ?>
			<?php include_partial('links', array('word' => $words[0])) ?>
			<?php //include_partial('comments', array('word' => $words[0])) ?>
		<?php endif ?>

	<?php endif ?>

<?php endif ?>

<?php if ($sf_user->isEditor()): ?>
	<div class="box">
		<h2>Добавяне на нова дума</h2>
		<div class="data">
			<div></div>
			<?php echo link_to_new_word($sf_user) ?>
		</div>
	</div>
<?php endif ?>

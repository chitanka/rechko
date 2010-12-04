<?php slot('title', 'Последни промени') ?>

<ul>
<?php foreach ($word_revs as $word_rev): ?>
	<?php if ($word_rev['field'] == 'NEW'): ?>
		<li>
			<?php echo link_to_word($word_rev['Word']) ?> created
			<?php echo $word_rev['User']['username'] ?>
		</li>
	<?php endif ?>
<?php endforeach ?>

<?php foreach ($word_revs as $word_rev): ?>
	<?php if ($word_rev['field'] == 'NEW'): ?>
		<li>
			<?php echo link_to_word($word_rev['Word']) ?> created
			<?php echo $word_rev['User']['username'] ?>
		</li>
	<?php endif ?>
<?php endforeach ?>
</ul>

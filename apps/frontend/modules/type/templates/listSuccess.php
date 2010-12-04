<?php slot('title', sprintf('Думи от тип %s (%s)', $type['name'], format_word_type($type['speech_part']))) ?>

<p><?php echo $type->comment ?></p>

<?php include_partial('list', array('words' => $pager->getResults())) ?>

<?php include_partial('global/pager', array('pager' => $pager, 'route' => '@type_list?name='.$type['name'])) ?>

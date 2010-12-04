<?php slot('title', sprintf('Превод на %s на %s', $translation['Word']['name'], myformat_language($translation['lang']))) ?>
<?php include_partial('translation', array('translation' => $translation)) ?>

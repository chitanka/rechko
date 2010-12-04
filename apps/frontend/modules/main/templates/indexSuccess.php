<?php use_helper('JavascriptBase') ?>
<?php slot('title', sfConfig::get('app_sitename')) ?>
<?php slot('sitename', ' ') ?>

<?php slot('header', get_partial('word/search_with_random')) ?>

<?php include_component('word', 'mostSearchedWords') ?>
<?php include_component('word', 'mostSearchedIncorrectForms') ?>
<?php //include_component('word', 'mostSearchedDerivativeForms') ?>
<?php echo javascript_tag('document.getElementById("q").focus()') ?>

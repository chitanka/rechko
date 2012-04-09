<?php
require_once dirname(__FILE__).'/../bootstrap/unit.php';
require_once dirname(__FILE__).'/../../lib/grammar/IncorrectFormsGenerator.class.php';

$t = new lime_test(1, new lime_output_color());

$t->diag('IncorrectFormsGenerator::getIncorrectForms()');

#$t->is(DateTimeUtil::addTime("22:00", "-23:00", '4:00'), '3:00', '');
print_r(IncorrectFormsGenerator::getIncorrectForms('абсу`рд'));

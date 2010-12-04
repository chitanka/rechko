<?php

/**
 * WordType filter form base class.
 *
 * @package    rechnik
 * @subpackage filter
 * @author     borislav
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseWordTypeFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'         => new sfWidgetFormFilterInput(),
      'idi_number'   => new sfWidgetFormFilterInput(),
      'speech_part'  => new sfWidgetFormFilterInput(),
      'comment'      => new sfWidgetFormFilterInput(),
      'rules'        => new sfWidgetFormFilterInput(),
      'rules_test'   => new sfWidgetFormFilterInput(),
      'example_word' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'name'         => new sfValidatorPass(array('required' => false)),
      'idi_number'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'speech_part'  => new sfValidatorPass(array('required' => false)),
      'comment'      => new sfValidatorPass(array('required' => false)),
      'rules'        => new sfValidatorPass(array('required' => false)),
      'rules_test'   => new sfValidatorPass(array('required' => false)),
      'example_word' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('word_type_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'WordType';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'name'         => 'Text',
      'idi_number'   => 'Number',
      'speech_part'  => 'Text',
      'comment'      => 'Text',
      'rules'        => 'Text',
      'rules_test'   => 'Text',
      'example_word' => 'Text',
    );
  }
}

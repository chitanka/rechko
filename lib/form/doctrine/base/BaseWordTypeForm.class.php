<?php

/**
 * WordType form base class.
 *
 * @method WordType getObject() Returns the current form's model object
 *
 * @package    rechnik
 * @subpackage form
 * @author     borislav
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseWordTypeForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'name'         => new sfWidgetFormInputText(),
      'idi_number'   => new sfWidgetFormInputText(),
      'speech_part'  => new sfWidgetFormInputText(),
      'comment'      => new sfWidgetFormTextarea(),
      'rules'        => new sfWidgetFormTextarea(),
      'rules_test'   => new sfWidgetFormTextarea(),
      'example_word' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'name'         => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'idi_number'   => new sfValidatorInteger(array('required' => false)),
      'speech_part'  => new sfValidatorString(array('max_length' => 60, 'required' => false)),
      'comment'      => new sfValidatorString(array('required' => false)),
      'rules'        => new sfValidatorString(array('required' => false)),
      'rules_test'   => new sfValidatorString(array('required' => false)),
      'example_word' => new sfValidatorString(array('max_length' => 100, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('word_type[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'WordType';
  }

}

<?php

/**
 * IncorrectForm form base class.
 *
 * @method IncorrectForm getObject() Returns the current form's model object
 *
 * @package    rechnik
 * @subpackage form
 * @author     borislav
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseIncorrectFormForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'name'            => new sfWidgetFormInputText(),
      'correct_word_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CorrectWord'), 'add_empty' => true)),
      'search_count'    => new sfWidgetFormInputText(),
      'deleted_at'      => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'name'            => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'correct_word_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CorrectWord'), 'required' => false)),
      'search_count'    => new sfValidatorInteger(array('required' => false)),
      'deleted_at'      => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('incorrect_form[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'IncorrectForm';
  }

}

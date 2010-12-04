<?php

/**
 * AbstractWord form base class.
 *
 * @method AbstractWord getObject() Returns the current form's model object
 *
 * @package    rechnik
 * @subpackage form
 * @author     borislav
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseAbstractWordForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'name'           => new sfWidgetFormInputText(),
      'name_stressed'  => new sfWidgetFormInputText(),
      'name_broken'    => new sfWidgetFormInputText(),
      'name_condensed' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'name'           => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'name_stressed'  => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'name_broken'    => new sfValidatorString(array('max_length' => 120, 'required' => false)),
      'name_condensed' => new sfValidatorString(array('max_length' => 80, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('abstract_word[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'AbstractWord';
  }

}

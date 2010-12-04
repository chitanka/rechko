<?php

/**
 * WordTranslation form base class.
 *
 * @method WordTranslation getObject() Returns the current form's model object
 *
 * @package    rechnik
 * @subpackage form
 * @author     borislav
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseWordTranslationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'      => new sfWidgetFormInputHidden(),
      'word_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Word'), 'add_empty' => true)),
      'lang'    => new sfWidgetFormInputText(),
      'content' => new sfWidgetFormTextarea(),
      'source'  => new sfWidgetFormChoice(array('choices' => array('eurodict' => 'eurodict', 'user' => 'user'))),
    ));

    $this->setValidators(array(
      'id'      => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'word_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Word'), 'required' => false)),
      'lang'    => new sfValidatorString(array('max_length' => 3, 'required' => false)),
      'content' => new sfValidatorString(array('required' => false)),
      'source'  => new sfValidatorChoice(array('choices' => array(0 => 'eurodict', 1 => 'user'), 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'WordTranslation', 'column' => array('word_id', 'lang')))
    );

    $this->widgetSchema->setNameFormat('word_translation[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'WordTranslation';
  }

}

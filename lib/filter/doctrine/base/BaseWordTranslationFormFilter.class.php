<?php

/**
 * WordTranslation filter form base class.
 *
 * @package    rechnik
 * @subpackage filter
 * @author     borislav
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseWordTranslationFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'word_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Word'), 'add_empty' => true)),
      'lang'    => new sfWidgetFormFilterInput(),
      'content' => new sfWidgetFormFilterInput(),
      'source'  => new sfWidgetFormChoice(array('choices' => array('' => '', 'eurodict' => 'eurodict', 'user' => 'user'))),
    ));

    $this->setValidators(array(
      'word_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Word'), 'column' => 'id')),
      'lang'    => new sfValidatorPass(array('required' => false)),
      'content' => new sfValidatorPass(array('required' => false)),
      'source'  => new sfValidatorChoice(array('required' => false, 'choices' => array('eurodict' => 'eurodict', 'user' => 'user'))),
    ));

    $this->widgetSchema->setNameFormat('word_translation_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'WordTranslation';
  }

  public function getFields()
  {
    return array(
      'id'      => 'Number',
      'word_id' => 'ForeignKey',
      'lang'    => 'Text',
      'content' => 'Text',
      'source'  => 'Enum',
    );
  }
}

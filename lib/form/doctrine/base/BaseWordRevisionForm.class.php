<?php

/**
 * WordRevision form base class.
 *
 * @method WordRevision getObject() Returns the current form's model object
 *
 * @package    rechnik
 * @subpackage form
 * @author     borislav
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseWordRevisionForm extends RevisionForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['object_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Word'), 'add_empty' => true));
    $this->validatorSchema['object_id'] = new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Word'), 'required' => false));

    $this->widgetSchema->setNameFormat('word_revision[%s]');
  }

  public function getModelName()
  {
    return 'WordRevision';
  }

}

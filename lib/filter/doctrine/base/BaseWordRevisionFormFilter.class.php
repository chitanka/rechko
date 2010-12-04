<?php

/**
 * WordRevision filter form base class.
 *
 * @package    rechnik
 * @subpackage filter
 * @author     borislav
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseWordRevisionFormFilter extends RevisionFormFilter
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['object_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Word'), 'add_empty' => true));
    $this->validatorSchema['object_id'] = new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Word'), 'column' => 'id'));

    $this->widgetSchema->setNameFormat('word_revision_filters[%s]');
  }

  public function getModelName()
  {
    return 'WordRevision';
  }

  public function getFields()
  {
    return array_merge(parent::getFields(), array(
      'object_id' => 'ForeignKey',
    ));
  }
}

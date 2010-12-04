<?php

/**
 * IncorrectFormRevision filter form base class.
 *
 * @package    rechnik
 * @subpackage filter
 * @author     borislav
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseIncorrectFormRevisionFormFilter extends RevisionFormFilter
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['object_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('IncorrectForm'), 'add_empty' => true));
    $this->validatorSchema['object_id'] = new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('IncorrectForm'), 'column' => 'id'));

    $this->widgetSchema->setNameFormat('incorrect_form_revision_filters[%s]');
  }

  public function getModelName()
  {
    return 'IncorrectFormRevision';
  }

  public function getFields()
  {
    return array_merge(parent::getFields(), array(
      'object_id' => 'ForeignKey',
    ));
  }
}

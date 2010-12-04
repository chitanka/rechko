<?php

/**
 * DerivativeForm filter form base class.
 *
 * @package    rechnik
 * @subpackage filter
 * @author     borislav
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseDerivativeFormFormFilter extends AbstractWordFormFilter
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['description'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['description'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['is_infinitive'] = new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no')));
    $this->validatorSchema['is_infinitive'] = new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0)));

    $this->widgetSchema   ['base_word_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('BaseWord'), 'add_empty' => true));
    $this->validatorSchema['base_word_id'] = new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('BaseWord'), 'column' => 'id'));

    $this->widgetSchema   ['search_count'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['search_count'] = new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false)));

    $this->widgetSchema->setNameFormat('derivative_form_filters[%s]');
  }

  public function getModelName()
  {
    return 'DerivativeForm';
  }

  public function getFields()
  {
    return array_merge(parent::getFields(), array(
      'description' => 'Text',
      'is_infinitive' => 'Boolean',
      'base_word_id' => 'ForeignKey',
      'search_count' => 'Number',
    ));
  }
}

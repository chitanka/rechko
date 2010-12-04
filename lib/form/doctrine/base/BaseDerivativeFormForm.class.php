<?php

/**
 * DerivativeForm form base class.
 *
 * @method DerivativeForm getObject() Returns the current form's model object
 *
 * @package    rechnik
 * @subpackage form
 * @author     borislav
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseDerivativeFormForm extends AbstractWordForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['description'] = new sfWidgetFormInputText();
    $this->validatorSchema['description'] = new sfValidatorString(array('max_length' => 150, 'required' => false));

    $this->widgetSchema   ['is_infinitive'] = new sfWidgetFormInputCheckbox();
    $this->validatorSchema['is_infinitive'] = new sfValidatorBoolean(array('required' => false));

    $this->widgetSchema   ['base_word_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('BaseWord'), 'add_empty' => true));
    $this->validatorSchema['base_word_id'] = new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('BaseWord'), 'required' => false));

    $this->widgetSchema   ['search_count'] = new sfWidgetFormInputText();
    $this->validatorSchema['search_count'] = new sfValidatorInteger(array('required' => false));

    $this->widgetSchema->setNameFormat('derivative_form[%s]');
  }

  public function getModelName()
  {
    return 'DerivativeForm';
  }

}

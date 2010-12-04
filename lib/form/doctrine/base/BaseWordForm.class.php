<?php

/**
 * Word form base class.
 *
 * @method Word getObject() Returns the current form's model object
 *
 * @package    rechnik
 * @subpackage form
 * @author     borislav
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseWordForm extends AbstractWordForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['meaning'] = new sfWidgetFormTextarea();
    $this->validatorSchema['meaning'] = new sfValidatorString(array('required' => false));

    $this->widgetSchema   ['synonyms'] = new sfWidgetFormTextarea();
    $this->validatorSchema['synonyms'] = new sfValidatorString(array('required' => false));

    $this->widgetSchema   ['classification'] = new sfWidgetFormTextarea();
    $this->validatorSchema['classification'] = new sfValidatorString(array('required' => false));

    $this->widgetSchema   ['type_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Type'), 'add_empty' => true));
    $this->validatorSchema['type_id'] = new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Type'), 'required' => false));

    $this->widgetSchema   ['pronounciation'] = new sfWidgetFormInputText();
    $this->validatorSchema['pronounciation'] = new sfValidatorString(array('max_length' => 100, 'required' => false));

    $this->widgetSchema   ['etymology'] = new sfWidgetFormTextarea();
    $this->validatorSchema['etymology'] = new sfValidatorString(array('required' => false));

    $this->widgetSchema   ['related_words'] = new sfWidgetFormTextarea();
    $this->validatorSchema['related_words'] = new sfValidatorString(array('required' => false));

    $this->widgetSchema   ['derived_words'] = new sfWidgetFormTextarea();
    $this->validatorSchema['derived_words'] = new sfValidatorString(array('required' => false));

    $this->widgetSchema   ['chitanka_count'] = new sfWidgetFormInputText();
    $this->validatorSchema['chitanka_count'] = new sfValidatorInteger(array('required' => false));

    $this->widgetSchema   ['chitanka_percent'] = new sfWidgetFormInputText();
    $this->validatorSchema['chitanka_percent'] = new sfValidatorNumber(array('required' => false));

    $this->widgetSchema   ['chitanka_rank'] = new sfWidgetFormInputText();
    $this->validatorSchema['chitanka_rank'] = new sfValidatorInteger(array('required' => false));

    $this->widgetSchema   ['search_count'] = new sfWidgetFormInputText();
    $this->validatorSchema['search_count'] = new sfValidatorInteger(array('required' => false));

    $this->widgetSchema   ['source'] = new sfWidgetFormChoice(array('choices' => array('bgoffice' => 'bgoffice', 'eurodict' => 'eurodict', 'idi' => 'idi', 'onlinerechnik' => 'onlinerechnik', 'user' => 'user')));
    $this->validatorSchema['source'] = new sfValidatorChoice(array('choices' => array(0 => 'bgoffice', 1 => 'eurodict', 2 => 'idi', 3 => 'onlinerechnik', 4 => 'user'), 'required' => false));

    $this->widgetSchema   ['other_langs'] = new sfWidgetFormTextarea();
    $this->validatorSchema['other_langs'] = new sfValidatorString(array('required' => false));

    $this->widgetSchema   ['deleted_at'] = new sfWidgetFormDateTime();
    $this->validatorSchema['deleted_at'] = new sfValidatorDateTime(array('required' => false));

    $this->widgetSchema->setNameFormat('word[%s]');
  }

  public function getModelName()
  {
    return 'Word';
  }

}

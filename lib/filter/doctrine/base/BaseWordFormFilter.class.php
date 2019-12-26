<?php

/**
 * Word filter form base class.
 *
 * @package    rechnik
 * @subpackage filter
 * @author     borislav
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseWordFormFilter extends AbstractWordFormFilter
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['meaning'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['meaning'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['synonyms'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['synonyms'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['classification'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['classification'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['type_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Type'), 'add_empty' => true));
    $this->validatorSchema['type_id'] = new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Type'), 'column' => 'id'));

    $this->widgetSchema   ['pronunciation'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['pronunciation'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['etymology'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['etymology'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['related_words'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['related_words'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['derived_words'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['derived_words'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['chitanka_count'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['chitanka_count'] = new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false)));

    $this->widgetSchema   ['chitanka_percent'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['chitanka_percent'] = new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false)));

    $this->widgetSchema   ['chitanka_rank'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['chitanka_rank'] = new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false)));

    $this->widgetSchema   ['search_count'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['search_count'] = new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false)));

    $this->widgetSchema   ['source'] = new sfWidgetFormChoice(array('choices' => array('' => '', 'bgoffice' => 'bgoffice', 'eurodict' => 'eurodict', 'idi' => 'idi', 'onlinerechnik' => 'onlinerechnik', 'user' => 'user')));
    $this->validatorSchema['source'] = new sfValidatorChoice(array('required' => false, 'choices' => array('bgoffice' => 'bgoffice', 'eurodict' => 'eurodict', 'idi' => 'idi', 'onlinerechnik' => 'onlinerechnik', 'user' => 'user')));

    $this->widgetSchema   ['other_langs'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['other_langs'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['deleted_at'] = new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate()));
    $this->validatorSchema['deleted_at'] = new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59'))));

    $this->widgetSchema->setNameFormat('word_filters[%s]');
  }

  public function getModelName()
  {
    return 'Word';
  }

  public function getFields()
  {
    return array_merge(parent::getFields(), array(
      'meaning' => 'Text',
      'synonyms' => 'Text',
      'classification' => 'Text',
      'type_id' => 'ForeignKey',
      'pronunciation' => 'Text',
      'etymology' => 'Text',
      'related_words' => 'Text',
      'derived_words' => 'Text',
      'chitanka_count' => 'Number',
      'chitanka_percent' => 'Number',
      'chitanka_rank' => 'Number',
      'search_count' => 'Number',
      'source' => 'Enum',
      'other_langs' => 'Text',
      'deleted_at' => 'Date',
    ));
  }
}

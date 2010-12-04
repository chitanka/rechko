<?php

/**
 * AbstractWord filter form base class.
 *
 * @package    rechnik
 * @subpackage filter
 * @author     borislav
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseAbstractWordFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'           => new sfWidgetFormFilterInput(),
      'name_stressed'  => new sfWidgetFormFilterInput(),
      'name_broken'    => new sfWidgetFormFilterInput(),
      'name_condensed' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'name'           => new sfValidatorPass(array('required' => false)),
      'name_stressed'  => new sfValidatorPass(array('required' => false)),
      'name_broken'    => new sfValidatorPass(array('required' => false)),
      'name_condensed' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('abstract_word_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'AbstractWord';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'name'           => 'Text',
      'name_stressed'  => 'Text',
      'name_broken'    => 'Text',
      'name_condensed' => 'Text',
    );
  }
}

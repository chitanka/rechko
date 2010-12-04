<?php

/**
 * BaseAbstractWord
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $name
 * @property string $name_stressed
 * @property string $name_broken
 * @property string $name_condensed
 * 
 * @method string       getName()           Returns the current record's "name" value
 * @method string       getNameStressed()   Returns the current record's "name_stressed" value
 * @method string       getNameBroken()     Returns the current record's "name_broken" value
 * @method string       getNameCondensed()  Returns the current record's "name_condensed" value
 * @method AbstractWord setName()           Sets the current record's "name" value
 * @method AbstractWord setNameStressed()   Sets the current record's "name_stressed" value
 * @method AbstractWord setNameBroken()     Sets the current record's "name_broken" value
 * @method AbstractWord setNameCondensed()  Sets the current record's "name_condensed" value
 * 
 * @package    rechnik
 * @subpackage model
 * @author     borislav
 * @version    SVN: $Id: Builder.php 7200 2010-02-21 09:37:37Z beberlei $
 */
abstract class BaseAbstractWord extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('abstract_word');
        $this->hasColumn('name', 'string', 100, array(
             'type' => 'string',
             'length' => '100',
             ));
        $this->hasColumn('name_stressed', 'string', 100, array(
             'type' => 'string',
             'length' => '100',
             ));
        $this->hasColumn('name_broken', 'string', 120, array(
             'type' => 'string',
             'length' => '120',
             ));
        $this->hasColumn('name_condensed', 'string', 80, array(
             'type' => 'string',
             'length' => '80',
             ));


        $this->index('condensed', array(
             'fields' => 
             array(
              0 => 'name_condensed',
             ),
             ));
    }

    public function setUp()
    {
        parent::setUp();
        
    }
}
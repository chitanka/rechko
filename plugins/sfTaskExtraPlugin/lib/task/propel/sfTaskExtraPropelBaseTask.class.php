<?php

if (!in_array('sfPropelPlugin', sfProjectConfiguration::getActive()->getPlugins()))
{
  return false;
}

/**
 * Base Propel task.
 *
 * @package     sfTaskExtraPlugin
 * @subpackage  task
 * @author      Kris Wallsmith <kris.wallsmith@symfony-project.com>
 * @version     SVN: $Id: sfTaskExtraPropelBaseTask.class.php 28187 2010-02-22 16:53:57Z Kris.Wallsmith $
 */
abstract class sfTaskExtraPropelBaseTask extends sfPropelBaseTask
{
  /**
   * Loads all model classes and returns an array of model names.
   * 
   * @return array An array of model names
   */
  protected function loadModels()
  {
    $models = array();

    $finder = sfFinder::type('file')->name('*TableMap.php');
    foreach ($finder->in($this->configuration->getModelDirs()) as $file)
    {
      $model = basename($file, 'TableMap.php');
      if (class_exists($model) && is_subclass_of($model, 'BaseObject'))
      {
        Propel::getDatabaseMap()->addTableFromMapClass(basename($file, '.php'));
        $models[] = $model;
      }
    }

    return $models;
  }
}

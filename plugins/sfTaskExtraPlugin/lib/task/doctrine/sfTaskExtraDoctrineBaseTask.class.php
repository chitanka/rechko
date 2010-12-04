<?php

if (!in_array('sfDoctrinePlugin', sfProjectConfiguration::getActive()->getPlugins()))
{
  return false;
}

/**
 * Base Doctrine task.
 *
 * @package     sfTaskExtraPlugin
 * @subpackage  task
 * @author      Kris Wallsmith <kris.wallsmith@symfony-project.com>
 * @version     SVN: $Id: sfTaskExtraDoctrineBaseTask.class.php 28187 2010-02-22 16:53:57Z Kris.Wallsmith $
 */
abstract class sfTaskExtraDoctrineBaseTask extends sfDoctrineBaseTask
{
  /**
   * Loads all model classes and returns an array of model names.
   * 
   * @return array An array of model names
   */
  protected function loadModels()
  {
    Doctrine_Core::loadModels($this->configuration->getModelDirs());

    $models = Doctrine_Core::getLoadedModels();
    $models = Doctrine_Core::initializeModels($models);
    $models = Doctrine_Core::filterInvalidModels($models);

    return $models;
  }
}

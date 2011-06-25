<?php

require_once dirname(__FILE__) . '/../lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
	public function setup()
	{
		if ( ! defined('Auth_OpenID_RAND_SOURCE')) {
			define('Auth_OpenID_RAND_SOURCE', null);
		}

		$this->enablePlugins(array(
			'sfDoctrinePlugin',
			'sfDoctrineGuardPlugin',
			'bmFeedbackPlugin',
			'sfPHPOpenIdPlugin',
			//'sfTaskExtraPlugin',
		));
	}

	public function configureDoctrine(Doctrine_Manager $manager)
	{
		$manager->setAttribute(Doctrine::ATTR_USE_DQL_CALLBACKS, true);
	}
}


function min_backtrace(){

	$output="";

	foreach(debug_backtrace() as $entry){
		$output.="\nFile: ".$entry['file']." (Line: ".$entry['line'].")\n";
		$output.="Function: ".$entry['function']."\n";
		//$output.="Args: ".implode(", ", $entry['args'])."\n";
	}

	return $output;
}
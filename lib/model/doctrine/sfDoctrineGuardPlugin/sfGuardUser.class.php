<?php

/**
 * sfGuardUser
 *
 *
 * @package    rechnik
 * @subpackage model
 * @author     borislav
 * @version    SVN: $Id$
 */
class sfGuardUser extends PluginsfGuardUser
{
	public function getSlug()
	{
		return $this->algorithm;
	}

	public function preInsert($event)
	{
		$this->algorithm = self::slugifyUsername($this->username);
	}

	static public function slugifyUsername($username)
	{
		$username = strtolower($username);
		$username = preg_replace('|https?://|', '', $username);
		$username = preg_replace('/[^a-z\d]/', '-', $username);
		$username = preg_replace('/--+/', '-', $username);
		$username = trim($username, '-');

		return $username;
	}

}

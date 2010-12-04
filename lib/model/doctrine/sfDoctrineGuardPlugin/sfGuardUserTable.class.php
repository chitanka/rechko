<?php

class sfGuardUserTable extends PluginsfGuardUserTable
{
	public function getBySlug($slug)
	{
		return $this->createQuery()
			->where('algorithm = ?', $slug)
			->fetchOne();
	}
}

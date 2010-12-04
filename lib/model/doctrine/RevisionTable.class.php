<?php

class RevisionTable extends Doctrine_Table
{
	// TODO remove sfContext dependance
	public function fromObjectUpdate($object)
	{
		$userId = $this->getUserId();

		$oldValues = $object->getModified(true);
		foreach ($object->getModified() as $field => $newValue) {
			if ($this->isHelpField($field)) {
				continue;
			}
			$rev = $this->create();
			$rev->fromArray(array(
				'object_id'    => $object->id,
				'field'     => $field,
				'old_value' => $oldValues[$field],
				'new_value' => $newValue,
				'user_id'   => $userId,
			));
			$rev->save();
		}
	}


	public function fromObjectInsert($object)
	{
		$rev = $this->create();
		$rev->fromArray(array(
			'object_id'    => $object->id,
			'field'     => 'NEW',
			'new_value' => serialize($object),
			'user_id'   => $this->getUserId(),
		));
		$rev->save();
	}


	public function fromObjectDelete($object)
	{
		$rev = $this->create();
		$rev->fromArray(array(
			'object_id'    => $object->id,
			'field'     => 'DELETE',
			'old_value' => serialize($object),
			'user_id'   => $this->getUserId(),
		));
		$rev->save();
	}

	protected function getUserId()
	{
		try {
			$userId = sfContext::getInstance()->getUser()->getId();
		} catch (sfException $e) {
			$userId = null;
		}

		return $userId;
	}


	protected function isHelpField($field)
	{
		return in_array($field, array('created_at', 'updated_at', 'deleted_at'));
	}
}

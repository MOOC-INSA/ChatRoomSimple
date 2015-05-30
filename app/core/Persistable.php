<?php
class Persistable
{
	private $id;
	public function setId($id)
	{
		$this->id = $id;
	}
	public function getId()
	{
		return $this->id;
	}
}
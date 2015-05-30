<?php

class DAO
{
	protected $_db;
	public $tableName;
	protected $idColumn;

	public function __construct($db,$tableName,$idColumn)
	{
		if(!$db)
		{
			$this->_db = Db::init();
		}
		else
		{
			$this->_db = $db;
		}
		$this->tableName = $tableName;
		$this->idColumn = $idColumn;
	}
	public function findAll()
	{
		$zouz = array();
		$sql = "SELECT * FROM ".$this->tableName;
		$req = $this->_db->prepare($sql);
		if($req->execute()){
			$ret = $req->get_result();
			while($row = $ret->fetch_assoc()) {
        		$zouz[] = $row;
    		}
		}
		
		return $zouz;
	}

	/*	public function findAll()
	{
		$zouz = array();
		$sql = "SELECT * FROM ".$this->tableName;
		$req = $this->_db->query($sql);
		while($row = $req->fetch_assoc()) {
        	$zouz[] = $row;
    	}
		return $zouz;
	}*/
	public function findAllAdvanced($sortingExpr, $from, $to)
	{
		$zouz = array();
		$sql = "SELECT * FROM ".$this->tableName;
		if($sortingExpr)
		{
			$sql.=" ORDER BY ".$sortingExpr;
		}
		if($from && $to)
		{
			$sql .= " LIMIT ".$from.",".$to;
		}
		$req=$this->_db->prepare($sql);

		if($req->execute())
		{
			$ret = $req->get_result();
			while($row = $ret->fetch_assoc())
			{
				$zouz[] = $row;
			}
		}
		return $zouz;
	}
	public function findById($id)
	{
		$ret = null;
		$sql = "SELECT * FROM ".
		$this->tableName.
		" WHERE ".
		$this->idColumn." = ?";
		$req = $this->_db->prepare($sql);
		$req->bind_param("s",$id);
		if($req->execute())
		{
			$tmp = $req->get_result();
			$ret =$tmp->fetch_assoc();
		}
		return $ret;
	}
	public function deleteById($id)
	{
		$ret = null;
		$sql = "DELETE FROM ".
		$this->tableName.
		"WHERE ".
		$this->idColumn." = ?";
		$req= $this->_db->prepare($sql);
		$req->bind_param("s", $id);
		if($req->execute())
		{
			$ret = $req->fetch();
		}
		return $ret;
	}
}
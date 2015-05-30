<?php
class RoomDAO extends DAO
{
	public function __construct()
	{
		require_once 'Room.php';
		$db = Db::init();
		parent::__construct($db,"rooms","id");
	}

	public function insert($room)
	{
		$ret = -1;
		$aName = $room->getAdminname();
		$rName = $room->getRoomname();
		$sql = "INSERT INTO rooms (roomname, adminname) VALUES (?, ?)";
		$req = $this->_db->prepare($sql);
		$req->bind_param("ss",$rName, $aName);
		if($req->execute())
		{
			$ret = $this->_db->insert_id;
		}
		return $ret;
	}
	public function deleteByName($roomname)
	{
		$ret = false;
		$sql = "DELETE FROM rooms WHERE roomname = ?";
		$req = $this->_db->prepare($sql);
		$req->bind_param("s",$roomname);
		if($req->execute())
		{
			$ret = true;
		}
		return $ret;
	}
	public function findAll()
	{
		$rooms = null;
		if($arrayResult = parent::findAll())
		{
			$rooms = array();
			foreach($arrayResult as $entry)
			{
				$room = new Room($entry['id'],$entry['roomname'],$entry['adminname']);
				array_push($rooms, $room);
			}
		}
		return $rooms;
	}
	public function findById($id)
	{
		$room = null;
		if($entry = parent::findById($id))
		{
			$room = new Room($entry['id'],$entry['roomname'],$entry['adminname']);
		}
		return $room;
	}
	public function findByName($roomname)
	{
		$room = null;
		$sql = "SELECT * FROM rooms WHERE roomname = ?";
		$req = $this->_db->prepare($sql);
		$req->bind_param("s",$roomname);
		if($req->execute()){
			$ret = $req->get_result();
			if($ret->num_rows>0){
				$entry = $ret->fetch_assoc();
				$room = new Room($entry['id'],$entry['roomname'],$entry['adminname']);
			}
		}
		return $room;
	}
}
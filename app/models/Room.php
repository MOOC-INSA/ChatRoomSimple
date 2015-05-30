<?php
class Room extends Persistable implements JsonAble{
	private $roomname;
	private $adminname;
	private $userDAO;

	public function __construct($id = null,$roomname,$adminname){
		if($id){
			$this->setId($id);
		}
		$this->userDAO = new UserDAO();
		$this->roomname = $roomname;
		$this->adminname = $adminname;
	}
	public function getRoomname(){
		return $this->roomname;
	}

	public function getAdminname(){
		return $this->adminname;
	}
	public function toJson(){
		return '{"roomname":"'.htmlspecialchars($this->roomname).'","adminname":"'.htmlspecialchars($this->adminname).'","count":'.htmlspecialchars($this->userDAO->countUsersInRoom($this->roomname)).'}';
	}
	public static function roomArrayToJson($rooms){
		$json = '{"rooms":[';
		foreach ($rooms as $room) {
			$json = $json.$room->toJson().',';
		}
		$json = substr($json, 0, strlen($json)-1);
		$json = $json.']}';
		return $json;
	}
}
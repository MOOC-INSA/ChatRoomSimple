<?php
class User extends Persistable implements JsonAble{
	private $username;
	private $roomname;

	public function __construct($id = null, $username, $roomname){
		if($id){
			$this->setId($id);
		}
		$this->username = $username;
		$this->roomname = $roomname;
		return $this;
	}
	public function getUsername(){
		return $this->username;
	}
	public function getRoomname(){
		return $this->roomname;
	}
	public function toJson(){
		return '{"username":"'.htmlspecialchars($this->username).'","roomname":"'.htmlspecialchars($this->roomname).'"}';
	}
	public static function userArrayToJson($users){
		$json = '{"users":[';
		foreach ($users as $user){
			$json = $json.$user->toJson().',';
		}
		$json = substr($json, 0, strlen($json)-1);
		$json = $json.']}';
		return $json;
	}
}
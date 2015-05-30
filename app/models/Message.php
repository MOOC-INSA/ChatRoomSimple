<?php
class Message extends Persistable implements JsonAble{
	private $username;
	private $roomname;
	private $text;
	private $date;

	public function __construct($id = null, $username, $roomname, $text, $date = null){
		if($id){
			$this->setId($id);
		}
		$this->username = $username;
		$this->roomname = $roomname;
		$this->text = $text;
		if($date == null){
			$date = date("Y-m-d H:i:s");
		}
		$this->date = $date;
		return $this;
	}
	public function getRoomname(){
		return $this->roomname;
	}
	public function getUsername(){
		return $this->username;
	}
	public function getText(){
		return $this->text;
	}
	public function getDate(){
		return $this->date;
	}
	public function toJson(){
		return '{"username":"'.htmlspecialchars($this->username).'","roomname":"'.htmlspecialchars($this->roomname).'","text":"'.htmlspecialchars($this->text).'","heure":"'.htmlspecialchars($this->date).'"}';
	}
	public static function messageArrayToJson($messages){
		$json = '{"messages":[';
		foreach ($messages as $message){
			$json = $json.$message->toJson().',';
		}
		$json = substr($json, 0, strlen($json)-1);
		$json = $json.']}';
		return $json;
	}
}
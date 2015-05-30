<?php
class MessageDAO extends DAO
{
	public function __construct()
	{
		require_once 'Message.php';
		$db = Db::init();
		parent::__construct($db,"messages","id");
	}
	public function insert($message)
	{
		$ret = -1;
		$uName = $message->getUsername();
		$rName = $message->getRoomname();
		$text = $message->getText();
		$date = $message->getDate();
		$sql = "INSERT INTO messages (username, roomname, text, date) VALUES (?, ?, ?,?)";
		$req = $this->_db->prepare($sql);
		$req->bind_param("ssss",$uName, $rName,$text, $date);
		if($req->execute())
		{
			$ret = $this->_db->lastInsertId();
		}
		return $ret;
	}
	public function deleteByRoom($roomname)
	{
		$ret = false;
		$sql = "DELETE FROM messages WHERE roomname = ?";
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
		$messages = null;
		if($arrayResult = parent::findAll())
		{
			$messages = array();
			foreach($arrayResult as $entry)
			{
				$message = new Message($entry['id'],$entry['username'],$entry['roomname'],$entry['text'], $entry['date']);
				array_push($messages, $message);
			}
		}
		return $messages;
	}
	public function findById($id)
	{
		$message = null;
		if($entry = parent::findById($id))
		{
			$message = new Message($entry['id'],$entry['username'],$entry['roomname'],$entry['text'], $entry['date']);
		}
		return $message;
	}
	public function findByRoom($roomname)
	{
		$messages = array();
		$sql = "SELECT * FROM messages WHERE roomname = ?";
		$req = $this->_db->prepare($sql);
		$req->bind_param("s",$roomname);
		if($req->execute())
		{
			$ret = $req->get_result();
			while($entry = $ret->fetch_assoc()) {
        		$messages[] = new Message($entry['id'],$entry['username'],$entry['roomname'],$entry['text'], $entry['date']);
    		}
    	}
		return $messages;
	}

}
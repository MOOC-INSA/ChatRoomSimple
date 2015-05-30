<?php
class UserDAO extends DAO{
	public function __construct()
	{
		require_once 'User.php';
		$db = Db::init();
		parent::__construct($db,"users","id");
	}
	public function insert($user)
	{
		$ret = -1;
		$uName = $user->getUsername();
		$rName = $user->getRoomname();
		$sql = "INSERT INTO users (username, roomname) VALUES (?, ?)";
		$req = $this->_db->prepare($sql);
		$req->bind_param("ss",$uName, $rName);
		if($req->execute())
		{
			$ret = $this->_db->insert_id;
		}
		return $ret;
	}
	public function deleteByName($username)
	{
		$ret = false;
		$sql = "DELETE FROM users WHERE username = ?";
		$req = $this->_db->prepare($sql);
		$req->bind_param("s",$username);
		if($req->execute())
		{
			$ret = true;
		}
		return $ret;
	}
	public function findAll()
	{
		$users = null;
		if($arrayResult = parent::findAll())
		{
			$users = array();
			foreach($arrayResult as $entry)
			{
				$user = new User($entry['id'],$entry['username'],$entry['roomname']);
				array_push($users, $user);
			}
		}
		return $users;
	}
	public function findById($id)
	{
		$user = null;
		if($entry = parent::findById($id))
		{
			$user = new User($entry['id'],$entry['username'],$entry['roomname']);
		}
		return $user;
	}
	public function findByRoom($roomname){
		$users = array();
		$sql = "SELECT * FROM users WHERE roomname = ?";
		$req = $this->_db->prepare($sql);
		$req->bind_param("s",$roomname);
		if($req->execute()){
			$ret = $req->get_result();
			if($ret->num_rows >0){
				while($entry = $ret->fetch_assoc()) {
        			$users[] = new User($entry['id'],$entry['username'],$entry['roomname']);
    			}
			}
		}
		return $users;
	}
	public function countUsersInRoom($roomname){
		$cmpt = null;
		$sql = "SELECT * FROM users WHERE roomname = ?";
		$req = $this->_db->prepare($sql);
		$req->bind_param("s",$roomname);
		if($req->execute())
		{
			$ret = $req->get_result();
			$cmpt = $ret->num_rows;
		}
		return $cmpt;
	}
	public function findByName($username)
	{
		$user = null;
		$sql = "SELECT * FROM users WHERE username = ?";
		$req = $this->_db->prepare($sql);
		$req->bind_param("s",$username);
		if($req->execute()){
			$ret = $req->get_result();
			if($ret->num_rows>0){
				$entry = $ret->fetch_assoc();
				$user = new User($entry['id'],$entry['username'],$entry['roomname']);
			}
		}
		return $user;
	} 
}
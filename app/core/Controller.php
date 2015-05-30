<?php
class Controller
{
	private $messageDAO;
	private $roomDAO;
	private $userDAO;
	private $room;
	private $username;
	private $isRoomSet = false;
	private $isUsernameSet = false;

	public function view($view, $data = [])
	{
		require_once '../app/views/'.$view.'View.php';
	}
	public function quitWithErrorTo($view, $error){
		http_response_code($error->getCode());
		$this->view($view, array("code"=>$error->getCode(), "log"=>$error->getLog()));
	}

	public function __construct(){
			$this->userDAO = new UserDAO();
			$this->roomDAO = new RoomDAO();
			$this->messageDAO = new MessageDAO();
			if(isset($_SESSION["roomname"])){
				$this->isRoomSet = true;
				$roomname = $_SESSION['roomname'];
				$this->room = $this->roomDAO->findByName($roomname);
			}
			if(isset($_SESSION["username"])){
				$this->isUsernameSet = true;
				$this->username = $_SESSION['username'];
			}
	}
	public function index()
	{
		if($this->isUsernameSet && $this->isRoomSet){
			$this->view('Room');
		}
		else{
			$this->view('Home');
		}

	}
	public function quitRoom(){
		if(!$this->isRoomSet || !$this->isUsernameSet){
			$this->quitWithErrorTo('Home', new Error(4));
		}else{
			if($this->room != null){
				if($this->username == $this->room->getAdminname()){
					$this->roomDAO->deleteByName($this->room->getRoomname());
					$this->messageDAO->deleteByRoom($this->room->getRoomname());
				}
			}
			$this->userDAO->deleteByName($this->username);
			$this->view('Home');
		}
	}
	public function getMessages(){
		if($this->isRoomSet){
			$ret = Message::messageArrayToJson(array(new Message(null, "","","",null)));
			if($this->room){
				if($messages = $this->messageDAO->findByRoom($this->room->getRoomname())) {
					$ret = Message::messageArrayToJson($messages);
				}
			}
			echo $ret;
		}else{
			$this->quitWithErrorTo('Home', new Error(2));
		}
	}
	public function getUsers(){
		if(!$this->isRoomSet){
			$this->quitWithErrorTo('Home', new Error(4));
		}else{
			$ret = User::userArrayToJson(array(new User(null,"","")));
			if($this->room){
				if($users = $this->userDAO->findByRoom($this->room->getRoomname())){
					$ret = User::userArrayToJson($users);
				}
			}
			echo $ret;
		}
	}
	public function sendMessage(){
		if(!isset($_POST["text"])){
			$this->quitWithErrorTo('Room', new Error(5));
		}else{
			echo 'ok';
			$text = htmlspecialchars($_POST["text"]);
			$this->messageDAO->insert(new Message(null, $this->username, $this->room->getRoomname(), $text, null));
		}
	}
	public function createRoom(){
		$roomname = htmlspecialchars($_POST["roomname"]);
		$username = htmlspecialchars($_POST["username"]);
		$existRoom = $this->roomDAO->findByName($roomname);
		if(!$existRoom){
			$existUser = $this->userDAO->findByName($username);
			if(!$existUser){
				$nUserTaRace = new User(null, $username, $roomname);
				$this->roomDAO->insert(new Room(null, $roomname, $username));
				$this->userDAO->insert($nUserTaRace);
				$this->sessionMe($username,$roomname);
				$this->view('Room', array("username" => $username, "roomname" => $roomname));
			}else{
				$this->quitWithErrorTo('Home', new Error(0));
			}
		}else{
			$this->quitWithErrorTo('Home', new Error(1));
		}
	}
	public function joinRoom(){
		$username = htmlspecialchars($_POST["username"]);		
		$roomname = htmlspecialchars($_POST["roomname"]);
		$existRoom = $this->roomDAO->findByName($roomname);
		if($existRoom){
			$existUser = $this->userDAO->findByName($username);
			if(!$existUser){
				$this->userDAO->insert(new User(null, $username, $roomname));	
				$this->sessionMe($username, $roomname);
				$this->view('Room', array("username" => $username, "roomname" => $roomname));
			}else{
				$this->quitWithErrorTo('Home',new Error(0));
			}
		}else{
			$this->quitWithErrorTo('Home',new Error(1));
		}
	}
	private function sessionMe($username, $roomname){
		$_SESSION["username"] = $username;
		$_SESSION["roomname"] = $roomname;
	}
	public function getRooms(){
		$json = Room::roomArrayToJson(array(new Room(null, "","")));
		if($ret = $this->roomDAO->findAll())
		{
			$json = Room::roomArrayToJson($ret);
		}
		echo $json;
	}
	public function eraseSession(){
		unset($_SESSION["username"]);
		unset($_SESSION["roomname"]);
	}
	public function test(){
		var_dump($this->userDAO->findByName("user177"));
	}
}
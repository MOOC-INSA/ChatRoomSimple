<?php
class Error implements JsonAble{

	private $errorCode;
	private $errorMessage;
	public function __construct($type){
		switch($type){
			case 0:
				$this->errorCode = 400;
				$this->errorMessage = "Username already exists";
				break;
			case 1:
				$this->errorCode = 400;
				$this->errorMessage = "Room already exists";
				break;
			case 2:
				$this->errorCode = 404;
				$this->errorMessage = "Room does not exist";
				break;
			case 3:
				$this->errorCode = 400;
				$this->errorMessage = "Bad username";
				break;
			case 4:
				$this->errorCode = 400;
				$this->errorMessage = "Bad roomname";
				break;
			case 5:
				$this->errorCode = 400;
				$this->errorMessage = "Bad message";
			default:
				$this->errorCode =200;
				break;
		}
	}
	public function getCode(){
		return $this->errorCode;
	}
	public function getLog(){
		return $this->errorMessage;
	}
	public function toJson(){
		return '{"code":'.$this->errorCode.',"error":"'.$this->errorMessage.'"}';
	}
}
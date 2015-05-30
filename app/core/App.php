<?php

class App
{
	//defaults values for controller, method & params
	private $controller = 'Controller';
	private $method = 'index';
	private $params = [];
	//function called whenever an instance of App is create
	public function __construct($method = null, $params = [])
	{
		$this->controller = new $this->controller;
		//check if the first element of the url is a known controller
		//if not the default value will be used
		if(isset($method) && method_exists($this->controller, $method))
		{
			$this->method = $method;
		}
		

		//checks if there is param gave in url
		$this->params = $params;
		//calls the chosen method of the chosen controller w. the parameters given 
		call_user_func_array([$this->controller, $this->method], $this->params);
	}
}
<?php
session_start();
$method = null;
if(isset($_GET["method"])){
	$method = $_GET["method"];
}
require_once '../app/init.php';

$app = new App($method);
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="/css/style.css">
		<title>Accueil</title>
		<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
		<script type="text/javascript" src="/js/app.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				beginHome();
			});
		</script>

	</head>
	<body>
		<header>
			<h1>This is the Main View</h1>
			<input id="errorCode" type="hidden" value="<?php 
				if(isset($data['code'])){
					echo $data['code'];
				}
			?>"/>
			<input id="errorLog" type="hidden" value="<?php 
				if(isset($data['log'])){
					echo $data['log'];
				}
			?>"/>

		</header>
		<div id="rooms">
			<a href="" class="roomlink" id="21"><p><strong>Room 1</strong> - 15 participants</p></a>
			<hr>
			<a href=""><p><strong>Room 2</strong> - 15 participants</p></a>
			<hr>
			<a href=""><p><strong>Room 3</strong> - 15 participants</p></a>

		</div>
		<div id="right">
			<hr>
			<table id="tablo">
				<tr>
					<td>
						<form action="?method=joinRoom" id="joinForm" method="post">
							<br>
							Username :<br>
							<input name="username" id="username" type="text" onblur="document.createForm.username.value = this.value;">
							<input name="roomname" id="roomnameToJoin" type="hidden">
							<br>
							<input id="joinButton" type="submit" value="Go">
						</form>
					</td>
					<td>
						<form action="?method=createRoom" name="createForm" method="post">
						<br>
						New room <br>
							<input name="roomname" id="roomname" type="text">
							<input type="hidden" name="username" />
							<br>
							<input id="createButton" type="submit" value="Create">
							<br> <br>
						</form>
					</td>
				</tr>
			</table>
		</div>
	</body>
</html>
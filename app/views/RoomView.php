<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="/css/style.css">
		<title>Room</title>
		<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
		<script type="text/javascript" src="/js/app.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				beginRoom();
			});
		</script>
		
	</head>
	<body>


		<header>
			
			<h1>This is the Room View</h1>
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

		<div id="messages">
			<p> <strong>User 1 :</strong><span class="message">Ceci est le premier message</span></p>
			<p> <strong>User 2 :</strong><span class="message">Ceci est le second message</span></p>
			<p class="myMessage"><strong>You :</strong><span class="message">Ceci est votre message</span></p>
		</div>
		<div id="users">
			<p>User 1</p>
			<p>User 2</p>
			<p>User 3</p>
		</div>
		<textarea id="writeMessage"></textarea>
			<button id="sendButton" type="submit">Send</button>
			<form id="quitRoomForm" name="quitRoom" action="?method=quitRoom" method="post">
				<input id="quitButton" type="submit" value="Quit"/>
			</form>
		<footer></footer>
	</body>
</html>
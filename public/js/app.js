function beginHome()
{
  getRooms();
  hasError();
  setInterval(getRooms, 3000);


  $("#createButton").on("click" , function( event ) {
    var roomname = $("#roomname").val();
    var username = $("#username").val();
    if(username != ""){
      if(roomname != ""){
        $("createForm").submit();
      }else{
        alert("Please enter a roomname");
        event.preventDefault();
      }
    }else{
      alert("Please enter an username");
      event.preventDefault();
    }
  });

   $("#joinButton").on("click" , function( event ) {
    var username = $("#username").val();
    if(username != ""){
      alert("Ok mate, now click on the room that you want to join");
      event.preventDefault();
    }else{
      alert("Please enter an username");
      event.preventDefault();
    }
  });

  $(document).on("click",".roomLink", function () {
    var roomname = $(this).attr("id");
    var username = $("#username").val();
    if(username!= ""){
      $("#roomnameToJoin").val(roomname);
      $("#joinForm").submit();
    }else{
      alert("Please enter an username");
    }
  });
}
function beginRoom()
{
  getMessages();
  getUsers();
  hasError();
  setInterval(getMessages, 3000);
  setInterval(getUsers, 3000);

  $( "#sendButton" ).click(function() {
    sendMessage();
  });

  $('#writeMessage').on('keyup', function(e){
    if (e.keyCode == 13) {
      sendMessage();
      $(this).parent('form').trigger('submit');
    }
  });
  $(document).on("click", "#quitButton" ,function() {
    $("quitRoom").submit();     
  });
}
function hasError(){
  $(document).ready(function(){
    var errorCode = $("#errorCode").val();
    var errorLog = $("#errorLog").val();
    if(errorCode){
      alert(errorLog);
    }
  });
}
function getRooms() {
   $.ajax({
   	url: '?method=getRooms',
   	dataType: "json",
   	success: function(data){
        	$('#rooms').empty();
        	$.each(data['rooms'], function(entryIndex, entry){
            if(entry["roomname"]!=''){
              var html = '<a class="roomLink" id="'+entry['roomname']+'"><p><strong>'+entry['roomname']+'</strong> - '+entry['count']+' participants</p></a><hr>';                             
              $('#rooms').append(html);
            }
        	});
      },
      error: function(jqXHR, textStatus, errorThrown) { 
      } 
   });
}
function getMessages() {
   $.ajax({
      url: '?method=getMessages',   
      dataType: "json",
      success: function(data){     
      	$('#messages').empty();    
      	$.each(data['messages'], function(entryIndex, entry){
          if(entry['username']!=''){
            var html = '<p> <strong>'+entry['username']+' :</strong><span class="message">'+entry['text']+'</span></p>';                                            
            $('#messages').append(html);
          }

        	});
      },
      error: function(jqXHR, textStatus, errorThrown) { 
      }
   });
}
function getUsers() {
	$.ajax({
    url: '?method=getUsers',
    dataType: "json",
    success: function(data){
   	  $('#users').empty();
      if(data['users'].length != 0){
        $.each(data['users'], function(entryIndex, entry){
          if(entry['username']!= ''){
            var html = '<p>'+entry['username']+'</p>';                                            
            $('#users').append(html);
          }else{
            $.post("?method=eraseSession", {} );
            location.reload();
          }
        });
      }    
    },
    error: function(jqXHR, textStatus, errorThrown) { 
    }
  });
}

function sendMessage() {
  var text = $("#writeMessage").val();
  if(text){
    $.post("?method=sendMessage", { text: text.replace(/\n/g,'')} );
    $("#writeMessage").val("");
  }else{
    alert("Please enter a message");
  }
}
function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
    }
    return "";
}

<?php

    session_start();
    $login_username = $_SESSION['username'];
    $current_path = $_SESSION['current_path'];

?>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>add a deck</title>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" 
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" 
  crossorigin="anonymous"></script>
</head>
<body>

<h1>Add a deck:</h1>
<form method="post">
    <input name="deck_or_card_title" id="deck_or_card_title"placeholder="deck name:" type="text">
    <button onclick="adddeck_clicked()">confirm</button>
</form>
<form action="index.php">
  <button>return to home page</button>
</form>
<?php
require_once("phpFiles/db_handler.php");?>
<script>
  
  function adddeck_clicked() {
    var deck_or_card_title = document.getElementById('deck_or_card_title').value;
    $.ajax({
      url: 'phpFiles/adddeck_clicked.php',
      method: 'POST',
      dataType: 'text',
      data: {
        deck_or_card_title:deck_or_card_title
      }  
                   
    }).done(function(returnedData){
        console.log(returnedData);
        window.alert(returnedData);
        
        
        //if (returnedData == "success"){
          //window.location.href = "index.php" ;
        


        
    })

  }

</script>
</body>
</html>


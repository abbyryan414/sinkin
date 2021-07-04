<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>signup page</title>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" 
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" 
  crossorigin="anonymous"></script>
</head>
<body>

<h1>sign up</h1>
<form method="post">
    <input name="user_name"id="user_name" placeholder="username:" type="text">
    <input name="password"id="password" placeholder="password:" type="text">
    <button onclick="signup_clicked()">confirm</button>
</form>
<button onclick="location.href='login.php'">Back to login page</button>
<?php
require_once("phpFiles/db_handler.php");?>

<script>
  
    function signup_clicked() {
      var user_name = document.getElementById('user_name').value;
      var password = document.getElementById('password').value;
    $.ajax({
      url: 'phpFiles/signup_clicked.php',
      method: 'POST',
      dataType: 'text',
      data: {
        user_name:user_name,
        password:password
      }  
                   
    }).done(function(returnedData){
        console.log(returnedData);
        window.alert(returnedData);
        
        
        if (returnedData == "success"){
          window.location.href = "login.php" ;
        }


        
    })
    
  }
</script>
</body>
</html>


<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>login page</title>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" 
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" 
  crossorigin="anonymous"></script>
</head>
<body>

<h1>log in</h1>
<form method="post">
    <input name="user_name" id="user_name"placeholder="username:" type="text">
    <input name="password" id="password"placeholder="password:" type="text">
    <a href="signup.php">don't have an account?click here</a>
    <button onclick="login_clicked()">confirm</button>
</form>
<?php
require_once("phpFiles/db_handler.php");?>
<script>
  
    function login_clicked() {
      var user_name = document.getElementById('user_name').value;
      var password = document.getElementById('password').value;
    $.ajax({
      url: 'phpFiles/login_clicked.php',
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
          window.location.href = "index.php" ;
        }


        
    })
    
  }
</script>
</body>
</html>





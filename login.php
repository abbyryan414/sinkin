<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>login page</title>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" 
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" 
  crossorigin="anonymous"></script>
<script src="https://unpkg.com/intro.js/minified/intro.min.js"></script>
<link rel="stylesheet" href="css_files/login.css">
<link href="https://unpkg.com/intro.js/minified/introjs.min.css" rel="stylesheet">
</head>
<body>
<div id="logo-div">
    <img id="logo" src="images/logob.png" alt="">
  </div>
  <div id=intro-div>
    <button id="intro" onclick="intro_clicked()">Guide me!</button> 
</div>
<div id= "login-div">
<h2 id="login_label" data-intro="Welcome to Sinkin! This is the login page.">Login!</h2>
</div>
<div id = "bar-div">
  <form method="post"> 
<div id = "user-div">
    <input name="user_name" id="user_name"placeholder="username:" type="text" data-intro="Here is where you put your Username...">
</div>
<div id = "pass-div">
    <input name="password" id="password"placeholder="password:" type="text" data-intro="And here is for your password.">
</div>
</div>
<div id = href-div>
    <a href="signup.php" data-intro="If you don't have an account, you can register here!">Don't have an account?</a>
</div>
<div id=loginB-div>
    <button id="loginB" onclick="login_clicked()">login!</button> 
</div>
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
    function intro_clicked(){
      introJs().start();
    }
    

</script>
</body>
</html>





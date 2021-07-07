<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sign up!</title>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" 
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" 
  crossorigin="anonymous"></script>
  <script src="https://unpkg.com/intro.js/minified/intro.min.js"></script>
  <link rel="stylesheet" href="css_files/signup.css">
  <link href="https://unpkg.com/intro.js/minified/introjs.min.css" rel="stylesheet">
</head>
<body>
<div id="logo-div">
  <img id="logo" src="images/logob.png" alt="">
</div>

<div id=intro-div>
  <button id="intro" onclick="intro_clicked()">Guide me!</button> 
  <div id= "sign-div">
    <h2 id=sign_label data-intro="Hello again! This is the Registration page.">Sign&nbsp;Up!</h2>
  </div>

  <div id = "bar-div">
    
    <div id = "user-div">
        <input name="user_name"id="user_name" data-intro="As before, this is where your username goes" placeholder="username:" type="text">
    </div>

    <div id = "pass-div">
        <input name="password"id="password" data-intro="And this is where your password goes" placeholder="password:" type="text">
    </div>
  </div>

  <div id=signB-div>
    <button id=signB data-intro="To finish, click this button to submit and register!" onclick="signup_clicked()">Sign&nbsp;In!</button>
  </div>
   
</div>
<div id=btl-div>
  <button id=btlB data-intro="You can also click this button to go back to the login page!" onclick="location.href='login.php'">Back to login page</button>
</div>
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

  function intro_clicked(){
      introJs().start();
    }
    


</script>
</body>
</html>


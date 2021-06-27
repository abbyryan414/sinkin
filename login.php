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
    <input name="user_name" placeholder="username:" type="text">
    <input name="password" placeholder="password:" type="text">
    <a href="signup.php">don't have an account?click here</a>
    <button name="confirm-btn">confirm</button>
</form>

</body>
</html>

<?php
if(array_key_exists('confirm-btn', $_POST)) { 

  require_once("phpFiles/db_handler.php");
    
  $user_name=$_POST['user_name'];
  $password=$_POST['password'];
    
    
  $value = "SELECT* FROM users WHERE username= '$user_name'";
  $result = $conn->query($value);
  $value1 = "SELECT* FROM users WHERE username= '$user_name' AND userpassword = '$password'";
  $result1 = $conn->query($value1);
    

  if ($result->num_rows > 0){
    if ($result1->num_rows > 0){
      session_start();
      $_SESSION['username'] = $user_name;
      $_SESSION['current_path'] = $user_name . "/";
      header("Location:index.php");
    }else{
      echo"incorrect password";
      //location.reload();
    }
  }else{
    echo"this username does not exist";
    //location.reload();
  }
  
            
}

?>
<?php 





  $user_name=$_POST['user_name'];
  $password=$_POST['password'];
 

  require_once("db_handler.php");
    
    
  $value = "SELECT* FROM users WHERE username= '$user_name'";
  $result = $conn->query($value);

  $value1 = "SELECT* FROM users WHERE username= '$user_name' AND userpassword = '$password'";
  $result1 = $conn->query($value1);
    

  if ($result->num_rows > 0){
    if ($result1->num_rows > 0){
      session_start();
      $_SESSION['username'] = $user_name;
      $_SESSION['current_path'] = $user_name . "/";
      
      echo"success";
    }else{
      echo"incorrect password";
     
    }
  }else{
    echo"this username does not exist";
    
  }

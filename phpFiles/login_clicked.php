<?php 




//if (isset($_POST['user_name'])) {
 // if (isset($_POST['password'])) {
  $user_name=$_POST['user_name'];
  $password=$_POST['password'];
  //echo "$user_name";
  //echo "$password";

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
      //header("Location:index.php");
      echo"success";
    }else{
      echo"incorrect password";
      //location.reload();
    }
  }else{
    echo"this username does not exist";
    //location.reload();
  }
//}
//}
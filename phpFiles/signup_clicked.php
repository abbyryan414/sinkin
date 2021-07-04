<?php 




  $user_name=$_POST['user_name'];
  $password=$_POST['password'];
  

  require_once("db_handler.php");

  $value = "SELECT* FROM users WHERE username= '$user_name'";
  $result = $conn->query($value);
    

  
  if (preg_match("(/)","$user_name")){
    echo "username cannot include / ";
    }elseif (strlen($user_name) > 0 && strlen(trim($user_name)) == 0){
        //check for space
        echo"username cannot be blank";
    }elseif (preg_match("(^[NULL]{0}$)","$user_name")){
        //check for blank
        echo"username cannot be blank";
    }elseif(strlen($password) > 0 && strlen(trim($password)) == 0){
            //check for space
            echo"password cannot be blank";
    }elseif (preg_match("(^[NULL]{0}$)","$password")){
            //check for blank
            echo"password cannot be blank";
    }elseif($result->num_rows > 0){
          echo"this username already exists";
          //location.reload();
    }else{
      $sql = "INSERT INTO users (username,userpassword)
      VALUES ('$user_name','$password')";
       echo"success";
    }
  
    
    
  

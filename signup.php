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
    <input name="user_name" placeholder="username:" type="text">
    <input name="password" placeholder="password:" type="text">
    <button name="confirm-btn">confirm</button>
</form>
<button onclick="location.href='login.php'">Back to login page</button>
</body>
</html>

<?php
if(array_key_exists('confirm-btn', $_POST)) { 

  require_once("phpFiles/db_handler.php");
    
  $user_name=$_POST['user_name'];
  $password=$_POST['password'];
    
    
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
          echo"this username alreadyn exists";
          //location.reload();
    }else{
      $sql = "INSERT INTO users (username,userpassword)
      VALUES ('$user_name','$password')";
      if ($conn->query($sql) === TRUE) {
        echo "<script>alert('signup success')</script>";
        } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
  }
  
            

?>
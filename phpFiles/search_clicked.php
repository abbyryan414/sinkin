<?php 
  session_start();
  $login_username = $_SESSION['username'];
  $current_path = $_SESSION['current_path'];

  $entered_word=$_POST['entered_word'];
        
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "database";
        $date = date('Y-m-d H:i:s');
        $number = 1 ;
        // Create connection 
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        }
        
        $value = "SELECT* FROM users_cards WHERE username= '$login_username' AND is_card = 1 AND (deck_or_card_title LIKE '%$entered_word%') OR (card_info LIKE '%$entered_word%')";
        $result = $conn->query($value);
        //check for names including 
        if (strlen($entered_word) > 0 && strlen(trim($entered_word)) == 0){
            //check for space
            echo "Card name cannot be blank";
            }elseif (preg_match("(^[NULL]{0}$)","$entered_word")){
            //check for blank
            echo "Card name cannot be blank";
            }elseif ($result->num_rows == 0){
                //no card found
                echo "no card found";
            }else{
              $_SESSION['search_checker'] = "true" ;
              $_SESSION['searched_word'] =  $entered_word;
              echo "success";
              
            }
        
        


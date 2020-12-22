<?php
        session_start();
        //get local time by inputing GMT value
        $local_time = getLocalTime($_SESSION['gmt_int']);
        echo "Local Time: ".$local_time."<br>";
      
        $deck_or_card_title=$_POST['deck_or_card_title'];
        $card_info=$_POST['card_info'];
        $login_username=$_POST['login_username'];


        //gets the deck the user selected (or the default deck if he didn't select one)
        $chosen_deck=$_POST['chosen_deck'];

        //store the deck the user selected to $_SESSION['selected_deck'], so that the default deck will be the deck the user has just selected
        // NOTE: will have to refresh in order for the default deck option to change
        $_SESSION['selected_deck'] = $chosen_deck;
        echo $_SESSION['selected_deck'];
    
        //select possible repeating card name
        $value = "SELECT * FROM users_cards WHERE username= '$login_username' AND deck_or_card_title = '$deck_or_card_title' AND currentpath = '$current_path$chosen_deck/'";
        $result = $conn->query($value);
        
        //check for names including /
        if (preg_match("(/)","$deck_or_card_title")){
        
            echo "Card name cannot include / ";
            
            }elseif (strlen($deck_or_card_title) > 0 && strlen(trim($deck_or_card_title)) == 0){
                //check for space of name
                echo "Card name cannot be blank";
            }elseif (preg_match("(^[NULL]{0}$)","$deck_or_card_title")){
                //check for blank of name
                echo "Card name cannot be blank";
            }elseif($result->num_rows > 0){
                //check for same card
                echo "Card name cannot be the same as an existing card";
            }else{
         
            //get the path of the deck the user has chosen, 
            //store it in $chosen_deck_path
            $value = "SELECT * FROM users_cards WHERE username= '$login_username' AND deck_or_card_title = '$chosen_deck' AND is_card='0'";
            $result = $conn->query($value);
            while($row=$result->fetch_assoc()){
              $chosen_deck_path = $row['currentpath'];
            }
        
            //insert data to table
            $sql = "INSERT INTO users_cards (username,currentpath,is_card,deck_or_card_title,card_info,created_date,study_date,reps)
            VALUES ('$login_username','$chosen_deck_path$chosen_deck/',TRUE,'$deck_or_card_title','$card_info','$local_time','$local_time','0')";
        
            if ($conn->query($sql) === TRUE) {
            echo "<br>". "New card added";
            //header("Location:index.php");
            } else {
            echo "Error: " . $sql . "<br>" . $conn->error;

            }
        
        }
            

 


?>
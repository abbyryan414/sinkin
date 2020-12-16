<?php
    session_start();
    $login_username = $_SESSION['username'];
    $current_path = $_SESSION['current_path'];
    

    echo "login_username: ".$login_username."<br>";
    echo "current_path: ".$current_path."<br>";

    //get last dir
    require_once("phpFiles/functions_library.php");
    $last_dir = getLastDir($current_path);
    echo "last_dir: ".$last_dir;



    $given_card_name =$_POST['givencardname'];
    $given_card_info=$_POST['givencardinfo'];
    $given_card_name ="hello";
    $given_card_info="used to greet people";

    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "database";
    $date = date('Y-m-d H:i:s');
    
    require_once("phpFiles/db_handler.php");
  
    $sql = "SELECT * FROM users_cards WHERE username= '$login_username' AND is_card = 0";
    $result = $conn->query($sql);
   
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>add a card</title>
</head>
<body>
    <h1>Add a card:</h1>
    <form method="post">
        <input name="deck_or_card_title" placeholder="card name:" value= "<?php echo $given_card_name ?>" type="text">
        <input name="card_info" placeholder="card info:" value= "<?php echo $given_card_info ?>"type="text">
        <select name='chosen_deck'>
            <?php
                while($row=$result->fetch_assoc()){
                    $deck_select_name = $row['deck_or_card_title'];

                    //Set the default value for the option selection to be 
                    // the current path
                    // Eg: If current path is Marco/Deck2, the default option will be Deck2
                    if ($deck_select_name == $last_dir) {
                      //auto generate options
                      echo "<option value='$deck_select_name' selected>
                              $deck_select_name
                          </option>";
                    } else {
                      //auto generate options
                      echo "<option value='$deck_select_name'>
                              $deck_select_name
                          </option>";
                    }
            
                }
            ?>
        </select>
        <button name="confirm-btn">confirm</button>
    </form>
    <form action="index.php">
                        <button>return to home page</button>
    </form>
    
</body>
</html>

<?php
    if(array_key_exists('confirm-btn', $_POST)) { 
        
        $deck_or_card_title=$_POST['deck_or_card_title'];
        $card_info=$_POST['card_info'];
        $chosen_deck=$_POST['chosen_deck'];
        
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
            VALUES ('$login_username','$chosen_deck_path$chosen_deck/',TRUE,'$deck_or_card_title','$card_info','$date','$date','0')";
            
            if ($conn->query($sql) === TRUE) {
            echo "<br>". "New card added";
            header("Location:index.php");
            } else {
            echo "Error: " . $sql . "<br>" . $conn->error;

            }
           
        }
                
    }
    

?>

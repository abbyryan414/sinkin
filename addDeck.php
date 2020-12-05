
<?php

    // $loginusername =$_POST['username'];
    // $currentpath=$_POST['pathway'];
    // $loginusername ="ryan1";
    // $currentpath="ryan1/";

    session_start();
    $loginusername = $_SESSION['username'];
    $currentpath = $_SESSION['current_path'];
    
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>add a deck</title>
</head>
<body>
    <h1>Add a deck:</h1>
    <form method="post">
        <input name="Deck_or_card_title" placeholder="deck name:" type="text">
        <button name="confirm-btn">confirm</button>
    </form>
    <form action="index.php">
                        <button>return to home page</button>
    </form>
    
</body>
</html>

<?php
    if(array_key_exists('confirm-btn', $_POST)) { 
        
        //session_start();
        $Deck_or_card_title=$_POST['Deck_or_card_title'];

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "database";
        $date = date('Y-m-d H:i:s');
        // Create connection 
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        }
        if (preg_match("(/)","$Deck_or_card_title")){
            echo "Deck name cannot include / ";
            }elseif (strlen($Deck_or_card_title) > 0 && strlen(trim($Deck_or_card_title)) == 0){
                echo "Deck name cannot be blank";
            }elseif (preg_match("(^[NULL]{0}$)","$Deck_or_card_title")){
                    echo "Deck name cannot be blank";
            }else{
            //insert data to table
            $sql = "INSERT INTO users_cards (Username,Currentpath,Is_card,Deck_or_card_title,Card_info,Created_date,Study_date,Reps)
            VALUES ('$loginusername','$currentpath',FALSE,'$Deck_or_card_title','null','$date','2020-01-01 00:00:00','0')";
            
            if ($conn->query($sql) === TRUE) {
            echo "<br>". "New deck added";
            } else {
            echo "Error: " . $sql . "<br>" . $conn->error;

            }
           
        }
                
    }

?>
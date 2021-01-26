<?php

    $loginusername =$_POST['username'];
    $currentpath=$_POST['pathway'];
    $loginusername ="ryan1";
    $currentpath="ryan1/";
    
?>
<script>
    function edit(){
        window.location.href = "EditCard.php";
        $.ajax({
        url: 'EditCard.php',
        method: 'POST',
        dataType: 'text',
        data: {
        card_id: "<?php echo $gen_card_id?>"
            }     
         })
    }
</script>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>search for a word</title>
</head>
<body>
    <h1>search a word:</h1>
    <form method="post">
        <input name="entered_word" placeholder="word to be searched:" type="text">
        <button name="confirm-btn">confirm</button>
    </form>
    <form action="home.php">
                        <button>return to home page</button>
    </form>
    
</body>
</html>

<?php
    if(array_key_exists('confirm-btn', $_POST)) { 
        

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
        
        $value = "SELECT* FROM users_cards WHERE username= '$loginusername' AND is_card = 1 AND (deck_or_card_title LIKE '%$entered_word%') OR (card_info LIKE '%$entered_word%')";
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
                $number = 0;
                while($row=$result->fetch_assoc()){
                    //auto generate results
                    $gen_card=$row['deck_or_card_title'];
                    $gen_card_info=$row['card_info'];
                    $gen_card_id=$row['id'];
                    $number = $number + 1 ;
                    echo "<br>";
                    echo "$number.$gen_card";
                    echo "<br>";
                    echo "$gen_card_info";
                    echo'<button onclick="edit()">edit the above card</button>';
                }
                $number = 0 ;
            }
        
        
                
    }

?>

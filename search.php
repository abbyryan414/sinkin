<?php
     session_start();
    $login_username = $_SESSION['username'];
    $current_path = $_SESSION['current_path'];
    $search_checker = $_SESSION['search_checker'];
    $entered_word = $_SESSION['searched_word'];
    //$loginusername =$_POST['username'];
    //$currentpath=$_POST['pathway'];
    //$loginusername ="ryan1";
    //$currentpath="ryan1/";
    
?>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" 
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" 
  crossorigin="anonymous"></script>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>search for a word</title>
    <link rel="stylesheet" href="css_files/add.css">
</head>
<body>
    <div id="logo-div">
      <img id="logo" src="images/logo.png" alt="">
    </div>
    <div id="big-div">

    <div id="search-div2">
      <h1>search a word:</h1>
      <form id="add_deck_form" method="post">
          <input name="entered_word" id="entered_word" placeholder="word to be searched:" type="text">
          <button id="confirm_btn" onclick="search_clicked()">confirm</button>
      </form>
      <form action="index.php">
        <button id="return_btn">return to home page</button>
      </form>
    </div>  
    <div id="remaining-div">
<?php
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
        $value = "SELECT* FROM users_cards WHERE username= '$login_username' AND is_card = 1 AND ((deck_or_card_title LIKE '%$entered_word%') OR (card_info LIKE '%$entered_word%'))";
        $result = $conn->query($value);
if ($search_checker == "true" ){
    $number = 0;
    while($row=$result->fetch_assoc()){
        //auto generate results
        $gen_card=$row['deck_or_card_title'];
        $gen_card_info=$row['card_info'];
        $gen_card_id=$row['id'];
       
        

        $number = $number + 1 ;
        echo "<div class='card_div'>";
        echo "<label class='card_name_label'>$number. &nbsp $gen_card</label>";
        echo "<label class='card_info_label'>$gen_card_info</label>";
        
        
        echo <<<EOT
        <button class="edit_btn" onclick='card_clicked("$gen_card_id")'>edit this card</button>
        EOT;
        echo "</div>";
    }
    $number = 0 ;
    $_SESSION['search_checker'] = "false" ;

}

?>
<script>
    function search_clicked() {
      var entered_word = document.getElementById('entered_word').value;
    $.ajax({
      url: 'phpFiles/search_clicked.php',
      method: 'POST',
      dataType: 'text',
      data: {
        entered_word:entered_word
      }  
                   
    }).done(function(returnedData){
        console.log(returnedData);
        if (returnedData != "success"){
        window.alert(returnedData);
        }
        
        
        


        
    })
    
  }
</script>   
    </div>
  </div>
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
                    
                    
                    echo <<<EOT
                    <button onclick='card_clicked("$gen_card_id")'>edit this card</button>
                    EOT;
                }
                $number = 0 ;
            }
        
        
                
    }

?>

<script>
    
    function card_clicked(card_id) {
  if (card_id === undefined) {
    card_id = "default card id";
  }

  $.ajax({
    url: 'phpFiles/editcard.php',
    method: 'POST',
    dataType: 'text',
    data: {
        card_id: card_id
    }               
  }).done(function(returnedData){
      console.log(returnedData);// console print returnedData(php echoed stuff)
      window.location.href = "EditCard.php";
  })
}
            
</script>


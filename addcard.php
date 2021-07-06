<?php

    session_start();

    //Get username and currentpath(before clicking addcard.php)
    $login_username = $_SESSION['username'];
    $current_path = $_SESSION['current_path'];
    
    // echo "login_username: ".$login_username."<br>";
    // echo "current_path: ".$current_path."<br>";

    //import function library 
    require_once("phpFiles/functions_library.php");

    // update the local time 
    //$_SESSION['gmt_int'] is the GMT value, for example HK has GMT value of +8
    // getLocalTime is a function that inputs GMT value and outputs local time
    $local_time = getLocalTime($_SESSION['gmt_int']);
    // echo "Local Time: ".$local_time."<br>";
  

    //gets the selected_deck (eg:Deck2) from index.php, so that the default deck option 
    // will be the selected deck
    $selected_deck = $_SESSION['selected_deck'];
    // echo "selected_deck: ".$selected_deck;


  
    require_once("phpFiles/db_handler.php");
  
    $sql = "SELECT * FROM users_cards WHERE username= '$login_username' AND is_card = 0";
    $result = $conn->query($sql);
   
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>add a card</title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" 
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" 
  crossorigin="anonymous"></script>
</head>
<body>

    <h1>Add a card:</h1>
    <form id="add_card_form" method="post">
        <h4>Card Name:</h4>
        <textarea name="deck_or_card_title_area" id="deck_or_card_title_area" cols="30" rows="10"></textarea><br>
        <h4>Card Info:</h4>
        <textarea name="card_info_area" id="card_info_area" cols="30" rows="10"></textarea><br>
        <select id="chosen_deck" name='chosen_deck'>
            <?php
              while($row=$result->fetch_assoc()){
                $deck_select_name = $row['deck_or_card_title'];

                //Set the default value for the option selection to be 
                // the selected deck
                // Eg: If current path is Marco/Deck2, the default option will be Deck2
                if ($deck_select_name == $selected_deck) {
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
        
        
       
  </form>
    <button id="confirm_btn" onclick="confirm()">Confirm</button>
    <form action="index.php">
      <button id="return_btn">Return to Home Page</button>
    </form>
    <script>
    function confirm() {
      var deck_or_card_title = document.getElementById('deck_or_card_title_area').value;
      var card_info = document.getElementById('card_info_area').value;
      var chosen_deck = $("#chosen_deck :selected").val();
      
      $.ajax({
        url: 'phpFiles/ajax_add_card.php',
        method: 'POST',
        dataType: 'text',
        data: {
          deck_or_card_title: deck_or_card_title,
          card_info: card_info,
          chosen_deck: chosen_deck
        }               
      }).done(function(returnedData){
          alert(returnedData);
          location.reload();
      })
    }
  </script>
</body>
</html>



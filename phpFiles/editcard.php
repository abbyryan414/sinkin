<?php

session_start();

// receive the name of the deck selected and current_path 
// from index.php
if (isset($_POST['card_id'])) {
 
  $card_id = $_POST['card_id'];
  
  

  //set new cardid
  $_SESSION['gen_card_id'] = $card_id;

}


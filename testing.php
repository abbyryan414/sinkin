<?php

require("phpFiles/functions_library.php");
session_start();

$local_time = getLocalTime($_SESSION['gmt_int']);

 //get new study_date
 $new_study_date = new_study_date(1);

 $new_study_date_string = $new_study_date->format('Y-m-d H:i:s');
 echo "<br>New Study Date: ".$new_study_date_string;
<?php

session_start();

if (isset($_POST['time_zone_offset'])) {

  $gmt_int = $_POST['time_zone_offset'];
  //$_SESSION['time_zone_offset'] = $time_zone_offset;

  $_SESSION['gmt_int'] = $gmt_int;

}




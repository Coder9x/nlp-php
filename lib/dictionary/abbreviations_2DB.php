<?php
require('../database/dbconfig.php');
$table_name = "dictionary_abbreviations";

//clean it before update it
$sql = "DELETE FROM `".$table_name."`";
$connection->query($sql);


include 'oxfox_abbreviations_2DB.php';
include 'us_states_abbreviations_2DB.php';


?>

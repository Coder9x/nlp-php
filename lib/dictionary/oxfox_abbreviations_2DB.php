<?php

/*
This function is used to update the database
from text files in the folder dictionary
*/
require('../database/dbconfig.php');

$file_path = "oxfox_abbreviations.txt";
$table_name = "dictionary_abbreviations";

if ($file = fopen($file_path, "r")) {
    while(!feof($file)) {
        $line = fgets($file);
        $keyword = explode("	",$line);
        //echo $keyword[0]."-->";
        //echo $keyword[1]."<br/>";

        if(strlen($keyword[0])>0 && strlen($keyword[1])>0){
          $sql = "INSERT INTO `".$table_name."`(`id_word`, `word`) VALUES ('$keyword[0]','$keyword[1]')";
          //echo $sql."<br/>";

          if ($connection->query($sql) === TRUE) {
                echo "inserted ".$keyword[0]." -> ".$keyword[1]." <br/>";
             } else {
                echo "ERROR ".$keyword[0]." -> ".$keyword[1]." <br/>";
             }
        }
    }
    fclose($file);
}

?>

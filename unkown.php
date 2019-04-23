<?php
require('lib/database/dbconfig.php');

$sql = "SELECT *  FROM `unkown_word`";
$result = $connection->query($sql);

if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()){
        $tmp =  preg_replace('/[^A-Za-z0-9\-]/', '', $row['id']);
        $tmp = str_replace(' ', '', $tmp);
        $tmp = str_replace('-', '', $tmp);

        $tmp = trim($tmp);

        if(strlen($tmp)==0){
          $sql = "DELETE FROM `unkown_word` WHERE `id` LIKE '".$row['id']."'";
          $connection->query($sql);
        }

        if(is_numeric($tmp)){
          echo $row['id']." : ".$tmp."<br/>";
          $sql = "DELETE FROM `unkown_word` WHERE `id` LIKE '".$row['id']."'";
          $connection->query($sql);
        }

      }
}

?>

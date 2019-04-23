<?php
require('lib/database/dbconfig.php');

$columns = array("subgenus","habit","flower_color","flower_scent","flower_shape","flower_symmetry","stamen_length","ploidy");
$columnid = array("2","5","7","8","9","10","11","14");
$i = 0;
foreach ($columns as $col) {

  $sql = "SELECT * FROM `Suggestion` WHERE `r_type` = '".$col."'";
  $result = $connection->query($sql);


  if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()){
            $rtext = remove_references($row['r_text']);

            $ws = explode(";",$rtext);


            $ws = array_unique($ws);


            foreach ($ws as $w) {

                $w2s = explode(",",$w);

                foreach ($w2s as $w2) {
                  $sql = "INSERT INTO `words`(`word`, `mid`) VALUES ( '".trim($w2)."', '".$columnid[$i]."')";
                  if(strlen(trim($w2))>0){
                    $connection->query($sql);
                  }
                }


            }



          }

  }
  $i++;
}




function remove_references($str){
  $arr = explode("[",$str);
  $result="";

  foreach ($arr as &$value) {
    $pos=strpos($value,"]");
    if(!($pos>0)){

      $result = $result.$value;

    }else{
      $result = $result.substr($value,$pos+1);
    }
  }
  return $result;
}


?>

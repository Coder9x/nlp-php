<?php
require('lib/nlp.php');
require('lib/database/dbconfig.php');


$sql = "SELECT *  FROM `edb_eflora`";
$result = $connection->query($sql);
$curr = 0;
$stop = 5;

$input = "";

if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()){
        $curr++;
        if($curr==$stop){
        //echo $row['text']."<br/>";
        $input = $row['text'];
        break;
        }

      }
}

echo $input;
$test_nlp = new nlp;
$result = $test_nlp->segmentation($input);

//print_r($result);


echo "<dl>";
$starttime = microtime(true);

foreach($result as $sen){
  $i=0;
  foreach ($sen as $sub_sen) {
    if($i==0){
      //echo "<dt>".$sub."<br/><mark>".$test_nlp->structure($sub)."</mark><dt>";

      foreach ($test_nlp->tokenize($sub_sen,"g") as $value) {
        echo "[".$value."]";
      }

      echo "<br/>";

      // part of speech
      $pos = $test_nlp->pos($sub_sen);
      foreach ($pos as $pos_w) {
        echo "{".$pos_w."}";
      }


      echo "<br/>";


    }else{
      //echo "<dd>".$sub."<br/><mark>".$test_nlp->structure($sub)."</mark><dd>";

      foreach ($test_nlp->tokenize($sub_sen,"g") as $value) {
        echo "[".$value."]";
      }

      echo "<br/>";

      // part of speech
      $pos = $test_nlp->pos($sub_sen);
      foreach ($pos as $pos_w) {
        echo "{".$pos_w."}";
      }

      echo "<br/>";


    }
    $i++;
  }
  $i=0;
  echo "------------------------------------------------------------------------<br/><br/>";
}

echo "</dl>";

$endtime = microtime(true);
$timediff = $endtime - $starttime;


echo "Speed: ".round($timediff,5)."<br/>";


?>

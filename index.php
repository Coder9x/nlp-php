<?php
require('lib/nlp.php');
require('lib/database/dbconfig.php');


echo "<select>";

$sql = "SELECT *  FROM `edb_eflora`";
$result = $connection->query($sql);
$curr = 0;
$stop = 90;

$input = "";

if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()){
        $curr++;
        if($curr==$stop){
        //echo $row['text']."<br/>";
        echo "<option value='volvo'>".$row['taxon']."</option>";

        $input = $row['text'];
        break;
        }

      }
}

echo "</select> <br/>";

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

      $tokens = $test_nlp->tokenize($sub_sen,"g");

      foreach ( $tokens as $token) {
        echo "[".$token."]";
      }

      echo "<br/>";

      // part of speech
      $token_index = 0;

      $partofspeech = $test_nlp->ner($tokens);
      foreach ($partofspeech as $p) {

        echo "".trim($tokens[$token_index])."  ::: ";
        $token_index++;

        foreach ($p as $value) {
           echo $value." ";
        }
        echo "<br/>";
      }
      //print_r($tokens);
      //print_r($partofspeech);

      echo "<br/>";


    }else{
      //echo "<dd>".$sub."<br/><mark>".$test_nlp->structure($sub)."</mark><dd>";

      $tokens = $test_nlp->tokenize($sub_sen,"g");

      foreach ( $tokens as $token) {
        echo "[".$token."]";
      }

      echo "<br/>";

      // part of speech
      $token_index = 0;
      foreach ($test_nlp->ner($tokens) as $p) {

        echo "".trim($tokens[$token_index])."  ::: ";
        $token_index++;

        foreach ($p as $value) {
           echo $value." ";
        }
        echo "<br/>";
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

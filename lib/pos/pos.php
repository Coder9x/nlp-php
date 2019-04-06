<?php

class pos{

  public function getPOS($words){
    $wordtypes_list =array();
    foreach($words as &$word) {
      array_push($wordtypes_list,$this->findWordType($word));
    }

    return $wordtypes_list;
  }

  public function findWordType($word){
    require($_SERVER["DOCUMENT_ROOT"].'/nlp/nlp-php/lib/database/dbconfig.php');
    $sql = "SELECT `word`,`wordtype`  FROM `entries` WHERE `word` LIKE '".$word."'";
    $result = $connection->query($sql);
    $wordtypes=array();
    if ($result->num_rows > 0) {
          $wordtype="";
          while($row = $result->fetch_assoc()){
              array_push($wordtypes,$row['wordtype']);
          }
    }


    return array_unique($wordtypes);;
  }


}

//$pos = new pos;
//$a = ["have","flower","tree"];
//print_r($pos->getPOS($a));
?>

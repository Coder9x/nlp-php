<?php

class collections{

  var $types = array();
  var $words  = array();
  var $hits = array();

  public function router($ner){
    require('lib/database/dbconfig.php');

    /** split to types and words */
    foreach ($ner as $value) {
      $values = explode(":",$value);
      //echo "word: ".$values[1]."<Br/>";
      //echo "fort: ".$this->removeBrackets($values[1])."<br/>";
      array_push($this->types,$values[0]);
      array_push($this->words,$this->removeBrackets($values[1]));
    }
    //print_r($this->words);
    //print_r($this->types);

    $tmp_key="";
    $key_types = array(); // important for searching
    $positions = array(); // position of key words
    array_push($this->types,"__"); // add a closing mark

    $curr = 0;
    foreach ($this->types as $type) {
      if($type!="__"){
        $tmp_key=$tmp_key." ".$type;
      }else{
        if(strlen(trim($tmp_key))>0){
          array_push($key_types,$tmp_key);
          array_push($positions,$curr-strlen($tmp_key)/3);
        }
        $tmp_key="";
      }
      $curr++;// keep track the positions
    }

    //print_r($this->types);
    //print_r($this->words);
    //print_r($positions);
    //$combied_structures = array();
    //$combied_ranges = array();

    //$this->types = array_unique($this->types);
    //print_r($key_types);

    foreach ($key_types as $key_type) {
      $sql = "SELECT morpheme.name as 'name',morpheme_type.structure as 'structure',morpheme_type.range as 'range'  FROM `morpheme_type` INNER JOIN `morpheme` ON morpheme.mid = morpheme_type.mid WHERE  '".trim($key_type)."'  LIKE  CONCAT('%', morpheme_type.structure, '%') ";
      $result = $connection->query($sql);
      if ($result->num_rows > 0) {
        $offset_pos = 0;
        while($row = $result->fetch_assoc()){
          //echo $row['name']." ".$row['mid']."<br/>";
          //echo $row['structure']."<br/>";
          //echo $row['range']."<br/>"; //

          $entity_range = $row['range']; // from DB
          $entity_type= $row['structure']; // from DB

          // has a rule for this object
          if(strlen(trim($entity_range))>0){
            $entity_word="";
            //echo "keytype ".$key_type."<br/>";
            $len = (strlen($entity_type)+1)/3;
            //echo "len ".$len."<br/>";
            //print_r($positions);
            foreach ($positions as $pos) {
              $passed = true;
              //echo "type :".$entity_type."<br/>";
              //echo "start pos: ".($pos+$offset_pos)."<br/>";
              //echo "end pos: ".(($len+$pos-1)+$offset_pos)."<br/>";
              //print_r($this->words);

              for($i=$pos+$offset_pos;$i<=(($len+$pos-1)+$offset_pos);$i++){
                if($i<sizeof($this->words)){
                  $entity_word=$entity_word." ".$this->words[$i];
                }

              }

              $offset_pos+=($len+$pos);


              //echo "word: ".$entity_word." end loop <br/>";


              $passed = $this->isInRange($entity_range,trim($entity_word),$entity_type);

              if($passed){
                //echo $row['name']."<br/>";
                array_push($this->hits,$row['name']);
              }

            }
          }else{
            // no rule, just add them
            array_push($this->hits,$row['name']);
          }
          //echo "<br/>";

        }
      }

    }



    //print_r($this->types);
    //print_r($this->words);

    for($i=0; $i<sizeof($this->words);$i++){
      if($this->types[$i]=="__"){
        $this->inWords($this->words[$i]);
      }
    }

    return array_unique($this->hits);


  }




  private function isInRange($ranges, $words,$types){

    $result = true;
    //echo $words." <Br/>";
    $ranges = explode(" ",$ranges);
    $words  = explode(" ",$words);
    $types  = explode(" ",$types);

    for($i=0;$i<sizeof($ranges);$i++){
      if($types[$i]=="SN"){
        $result= $this->compareSNs($ranges[$i],$words[$i]);
      }else if($types[$i]=="RN"){
        $result= $this->compareRNs($ranges[$i],$words[$i]);
      }else if ($types[$i]=="LU"){
        $words[$i] = $this->cleanWord($words[$i]);
        $result= $this->compareList($ranges[$i],$words[$i]);
      }else if ($types[$i]=="CL"){
        $words[$i] = $this->cleanWord($words[$i]);
        $result= $this->compareList($ranges[$i],$words[$i]);
      }
      if(!$result){
        return false;
      }
    }

    return true;
  }





  private function compareList($range,$word){
    $ranges = explode(",",$range);
    foreach ($ranges as $range) {
      if($word==$range){
        return true;
      }
    }

    return false;

  }

  private function compareSNs($range, $word){
    //echo $range." ".$word."<br/>";
    $arr_range = explode("-",$range);
    $min_range = $arr_range[0];
    $max_range = $arr_range[1];

    if($word >= $min_range && $word <=$max_range){
      return true;
    }
    return false;

  }

  private function compareRNs($range, $word){

    $arr_range = explode("-",$range);
    $min_range = $arr_range[0];
    $max_range = $arr_range[1];
    $diff_min_range = $arr_range[2];
    $diff_max_range = $arr_range[3];


    $arr_word = explode("–",$word);
    if(sizeof($arr_word)<2){
      $arr_word = explode("-",$word);
    }

    if(sizeof($arr_word)<2){
      return false;
    }
    $min_word = $arr_word[0];
    $max_word = $arr_word[1];
    $diff_word = $arr_word[1]-$arr_word[0];


    if($min_word >= $min_range && $max_word <=$max_range
      && $diff_word<=$diff_max_range   && $diff_word>=$diff_min_range
      ){
      return true;
    }
    return false;



  }


  private function inWords($key){
    require('lib/database/dbconfig.php');
    $sql = "SELECT * FROM `words` INNER JOIN `morpheme` ON morpheme.mid = words.mid WHERE words.word LIKE '".$key."'";
    $result = $connection->query($sql);
    if ($result->num_rows > 0) {

      while($row = $result->fetch_assoc()){
        array_push($this->hits,$row["name"]);
      }
    }
    return false;

  }

  private function removeBrackets($word){
    $index_open = strpos($word,"(");
    $index_close = strpos($word,")");
    if($index_open>=0 && $index_close>=1){
      return $word = substr($word,0,$index_open).substr($word,$index_close+1);
    }else{
      return $word;
    }
  }

  private function cleanWord($word){
    $word = str_replace("?","",$word);
    $word = str_replace(".","",$word);
    return $word;
  }





}


?>

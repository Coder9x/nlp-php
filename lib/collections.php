<?php

class collections{

  var $types = array();
  var $words  = array();
  var $hits = array();

  public function router($ner){
    $point = 0;

    foreach ($ner as $value) {
      $values = explode(":",$value);
      //echo "word: ".$values[1]."<Br/>";
      //echo "fort: ".$this->removeBrackets($values[1])."<br/>";
      array_push($this->types,$values[0]);
      array_push($this->words,$this->removeBrackets($values[1]));
    }
    //print_r($this->words);
    //print_r($this->types);


    $string_types = "";
    foreach ($this->types as $type) {
      $string_types=$string_types."-".$type;
    }

    //echo $string_types."<br/>";

    // find units
    $index_LU = strpos($string_types, '-LU');

    // has units
    if($index_LU>=0){
      // if untis equal to "m" (meter)
      //echo $this->words[$index_LU/3]."<br/>";
      if($this->words[$index_LU/3]=="m"){
        $index_RNLU = strpos($string_types, '-RN-LU');
        $index_SNLU = strpos($string_types, '-SN-LU');

        // convert to index of the array
        $index_RNLU=$index_RNLU/3;
        $index_SNLU=$index_SNLU/3;

        //echo "index rnlu:".$index_RNLU."<br/>";
        //echo "index snlu:".$index_SNLU."<br/>";

        if($index_RNLU>=0) {
            if($this->isElevation($index_RNLU)){
               array_push($this->hits,"Evalation");
            }
            if($this->isHabit($index_RNLU)){
               array_push($this->hits,"Habit");
            }
        }else if($index_SNLU>=0) {
          if($this->isElevation($index_SNLU)){
               array_push($this->hits,"Evalation");
          }
          if($this->isHabit($index_RNLU)){
             array_push($this->hits,"Habit");
          }
        }

      }
    }

    // find color
    $index_CL= strpos($string_types, '-CL')/3;
    if($index_CL>=0){
      if($this->isFlowerColor($index_CL)){
         array_push($this->hits,"Flower color");
      }
    }

    // find color
    $index_PL= strpos($string_types, '-PL')/3;
    if($index_PL>=0){
      if($this->isDistribution($index_PL)){
         array_push($this->hits,"Geographic Distribution");
      }
    }


    // find __ tag
    $index__=0;
    foreach ($this->types as $type) {
      if($type=="__"){
        //echo "...".$this->words[$index__]."<br/>";
        $this->inWords($this->words[$index__]);
      }
      $index__++;
    }

    return $this->hits;


  }


  public function isElevation($index){

      if($this->types[$index]=="SN"){
        if($this->words[$index]>=0 && $this->words[$index]<=3000){
          return true;
        }
      }
      if($this->types[$index]=="RN"){
        $values = explode("–",$this->words[$index]);
        if(sizeof($values)<2){
          $values = explode("-",$this->words[$index]);
        }
        if($values[0]>=0 && $values[1]<=6000){
          return true;
        }
      }
  }


  public function isHabit($index){

    if($this->types[$index]=="SN"){
      if(($this->words[$index])>=0.1 && ($this->words[$index])<=10){

        return true;
      }
    }
    if($this->types[$index]=="RN"){
      $values = explode("–",$this->words[$index]);
      if(sizeof($values)<2){
        $values = explode("-",$this->words[$index]);
      }

      if(($values[0])>=0.1 && ($values[1])<=10){
        return true;
      }
    }

    return false;


  }

  public function isFlowerColor($index){

    if($this->types[$index]=="CL"){
        return true;
    }
    return false;
  }

  public function isDistribution($index){
    if($this->types[$index]=="PL"){
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





}


?>

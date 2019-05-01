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

    /** convert array types to string for finding by using strpos
    $string_types = "";
    foreach ($this->types as $type) {
      $string_types=$string_types."-".$type;
    }

    echo $string_types."<br/>";*/

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

    $this->types = array_unique($this->types);
    //print_r($key_types);

      foreach ($key_types as $key_type) {
        $sql = "SELECT morpheme.name as 'name',morpheme_type.structure as 'structure',morpheme_type.range as 'range'  FROM `morpheme_type` INNER JOIN `morpheme` ON morpheme.mid = morpheme_type.mid WHERE  '".trim($key_type)."'  LIKE  CONCAT('%', morpheme_type.structure, '%') ";
        $result = $connection->query($sql);
        if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()){
            //echo $row['name']." ".$row['mid']."<br/>";
            //echo $row['struct']."<br/>";
            //echo $row['range']."<br/>"; //

            $entity_range = $row['range']; // from DB
            $entity_type= $row['structure']; // from DB

            // has a rule for this object
            if(strlen(trim($entity_range))>0){
              $entity_word="";
              //echo "keytype ".$key_type."<br/>";
              $len = strlen($key_type)/3;
              //echo "len ".$len."<br/>";
              //print_r($positions);
                foreach ($positions as $pos) {
                  $passed = true;
                  //echo "start pos: ".$pos."<br/>";
                  //echo "end pos: ".($len+$pos-1)."<br/>";
                  // print_r($this->words);

                  for($i=$pos;$i<=($len+$pos-1);$i++){
                    if($i<sizeof($this->words)){
                      $entity_word=$entity_word." ".$this->words[$i];
                    }

                  }

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






        /* find structures
        $structures = array();
        $ranges = array();

        for($i=0;$i<sizeof($combied_structures);$i++){
          $orS = explode("|",$combied_structures[$i]);
          $orR = explode("|",$combied_ranges[$i]);

          if(sizeof($orS)==2){
            $firstS = explode(",",$orS[0]);
            $secondS = explode(",",$orS[1]);

            $firstR = explode(",",$orR[0]);
            $secondR = explode(",",$orR[1]);

            for($x=0; $x<sizeof($firstS);$x++){
              for($y=0; $y<sizeof($secondS);$y++){
                array_push($structures,"-".$firstS[$x]."-".$secondS[$y]);
                array_push($ranges,$firstR[$x]."-".$secondR[$y]);
              }
            }

          }else{
            array_push($structures,"-".$combied_structures[$i]);
            array_push($ranges,"-".$combied_ranges[$i]);

          }

        }


        //print_r($structures);
        //print_r($ranges);
        //print_r($this->types);
      //  print_r($this->words);


        foreach ($structures as $structure) {
          $index_start = strpos($string_types, $structure)/3;
          $atStart = substr($string_types,0,strlen($structure));
          if($index_start>0 || $atStart==$structure){
            if($atStart==$structure){
              $index_start=0;
            }

            $index_end = strlen($structure)/3+$index_start-1;
            echo $index_start."-".$index_end."<br/>";

            echo $this->types[$index_start]."<br/>";
            echo $ranges[$index_start];

        }
      }




        // check each case
        foreach ($structures as $structure) {
          //echo $structure." <-- <br/>";
          $index_start = strpos($string_types, $structure)/3;
          $atStart = substr($string_types,0,strlen($structure));
          if($index_start>0 || $atStart==$structure){
            if($atStart==$structure){
              $index_start=0;
            }

            $index_end = strlen($structure)/3+$index_start-1;
            //echo "found it <br/>";
            //echo $this->types[$index]."<br/>";

          //  echo $index_start."-".$index_end."<br/>";

            $match = true;
            for($index = $index_start;$index< $index_end;$index++){
              //echo "type index ".$this->types[$index]."<Br/>";
              if($this->types[$index]=="SN"){



                  $min_max = explode(":",$ranges[$index]);
                  $min = $min_max[0];
                  $max = $min_max[1];

                  if($min>$this->words[$index] && $this->words[$index] > $max){
                    $match = false;
                    //break;
                  }
              }

              if($this->types[$index]=="RN"){

                  //echo " WORD  ".$this->words[$index]."<br>";
                  $start_end = explode("–",$this->words[$index]);
                  if(sizeof($start_end)<2){
                    $start_end = explode("-",$this->words[$index]);
                  }
                  $start = $start_end[0];
                  $end= $start_end[1];

                  //echo " START  ".$start."<br>";
                //  echo " END  ".$end."<br>";

                  //echo " ranges  ".$ranges[$index]."<br>";
                  $min_max = explode(":",$ranges[$index]);

                  $min = $min_max[0];
                  $max = $min_max[1];

                  if($min>$start && $end > $max){
                    $match = false;
                    //break;
                  }
              }

              if($this->types[$index]=="LU"){
                $units = explode(",",$this->words[$index]);
                $tmp_bl = false;
                foreach ($units as $unit) {
                  if($unit==$this->words[$index]){
                    $tmp_bl=true;
                  }
                }
                if(!$tmp_bl){
                  $match = false;
                  //break;
                }

              }
            }// end check

            if($match){
              //echo "YEssss";
            }

            break; // found it, break, go to next token
          }

        }
*/











    /*
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
    */
    return array_unique($this->hits);


  }


  public function isElevation($index){




      if($this->types[$index]=="SN"){
        if($this->words[$index]>=0 && $this->words[$index]<=6000){
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



  private function isInRange($ranges, $words,$types){
    $result = true;

    $ranges = explode(" ",$ranges);
    $words  = explode(" ",$words);
    $types  = explode(" ",$types);


    for($i=0;$i<sizeof($ranges);$i++){
      if($types[$i]=="SN"){
        $result= $this->compareSNs($ranges[$i],$words[$i]);
      }else if($types[$i]=="RN"){
        $result= $this->compareRNs($ranges[$i],$words[$i]);
      }else if($types[$i]=="LU"){
        $result= $this->compareLUs($ranges[$i],$words[$i]);
      }
      if(!$result){
        return false;
      }
    }

    return true;
  }


  private function compareLUs($range,$word){
    $words = explode(",",$word);
    $ranges = explode(",",$range);

    $curr = 0;
    foreach ($words as $word) {
      if($word!=$ranges[$curr]){
        return false;
      }
      $curr++;
    }

    return true;

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

    $arr_word = explode("–",$word);
    if(sizeof($arr_word)<2){
      $arr_word = explode("-",$word);
    }
    $min_word = $arr_word[0];
    $max_word = $arr_word[1];

    if($min_word >= $min_range && $max_word <=$max_range){
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

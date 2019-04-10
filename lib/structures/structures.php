<?php

class structure
{

  var $struct_sentence = "";


  public function construct($sentence){
    $sentence = trim($sentence);
    // layer 1: check first part only
    $firstPart = explode(", ",$sentence);
    $this->findColon($firstPart[0],$sentence);
    $this->findNumber($firstPart[0],$sentence);
    return $this->struct_sentence;


  }

  private function findColon($firstPart,$sentence){
    $pos = strpos($firstPart, ': ');
    if ($pos!==false) {
        $this->struct_sentence = $this->addBraces($pos,$sentence);
    }
  }

  private function findNumber($firstPart,$sentence){
      $words = explode(" ",$firstPart);
      $isNumber = false;
      $pos=0;
      // check each word in the first part
      foreach($words as $word){
        // check each char in the first part
        $isNumber = false;
        $chars = str_split($word);
        foreach ($chars as $char) {
          if (is_numeric($char)) { // this is a number
            $isNumber=true;
            break;
          }
        }

        if($isNumber){
          break;
        }

        $pos=$pos+strlen($word)+1;

      }

      if ($isNumber) {
          $this->struct_sentence = $this->addBraces($pos,$sentence);
      }

  }



  private function addBraces($pos,$sentence){
    $text_with_braces = "{".substr($sentence,0,$pos)."}{".substr($sentence,$pos)."}"; // subject
    return $text_with_braces;
  }


  public function findSubject($sentence){
    $sentence= trim($sentence);
    $tokenizers = new tokenizers;
    $removed_punctuation = preg_replace('/[^\p{L}\p{N}\s]/u', '', $sentence);
    $words = $tokenizers->split2Word($removed_punctuation);

    //

    $subject = "";
    // check easy signal



    //find the noun ~ subject
    foreach ($words as $word) {
      $cases = $this->isNoun($word);
      // noun -> continue to check
      if($cases){
        $subject=$subject.$word." ";
        break;
      }
    }
    return $subject;
  }





  private function isNoun($word){
    require($_SERVER["DOCUMENT_ROOT"].'/nlp/nlp-php/lib/database/dbconfig.php');
    $word = rtrim($word,'s');
    $sql = "SELECT `word`,`wordtype`  FROM `entries` WHERE `word` LIKE '".$word."' AND `wordtype` LIKE '%n.%'";
    $result = $connection->query($sql);

    $isNoun = false; // not found
    if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()){
            if (strpos($row['wordtype'], 'n.') !== false) { // contain 'n.'
              $isNoun= true;
              break;
            }
          }
    }
    return $isNoun;

  }

}


//$struc = new structure;
//$result = $struc->findSubject("hello, how are you");
//echo $result;


?>

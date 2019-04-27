<?php
/**
 *
 */

require('wordtype.php');

class ner
{

  var $structure = array();

  public function define($tokens){
    $wordtype = new wordtype;

    // process each  token
    foreach ($tokens as $token) {
      $token = trim($token);
      $words = explode(" ",$token);

      $stuct_token = array();
      // create struct for each token
      for($index=0; $index < sizeof($words); $index++){
        $words[$index] = $this->clean($words[$index]);
        if($wordtype->isRangeNumber($words[$index])){
           array_push($stuct_token,"RN:".$words[$index]);
        }else if($wordtype->isLengthUnits($words[$index])){
          array_push($stuct_token,"LU:".$words[$index]);
        }else if($wordtype->isColor($words[$index])){
          array_push($stuct_token,"CL:".$words[$index]);
        }else if($wordtype->isSingleNumber($words[$index])){
          array_push($stuct_token,"SN:".$words[$index]);
        }else if($wordtype->isPlace($words[$index])==1){
          array_push($stuct_token,"PL:".$words[$index]);
        }else if($wordtype->isPlace($words[$index])==2){
          array_push($stuct_token,"PL:".$words[$index]);
          if(ctype_upper(substr($words[$index],0,1))){
                array_push($stuct_token,"PL:".$words[$index]);
                $index++; // skip the next word
          }
        }
        else{
           array_push($stuct_token,"__:".$words[$index]);
        }


      }
      // add struct to the sentence
      array_push($this->structure,$stuct_token);


    }
    return $this->structure;
  }

 private function clean($string) {
   $string = trim($string);
   $string = str_replace(',', '', $string);
   $string = $this->removeBrackets($string);
   //$string = str_replace('.', '', $string);
   return $string;
   //return preg_replace('/[^A-Za-z0-9\-]/', ' ', $string);
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

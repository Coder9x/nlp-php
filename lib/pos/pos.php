<?php
/**
 *
 */

require('wordtype.php');

class pos
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
      foreach ($words as $word) {
        $word = $this->clean($word);
        if($wordtype->isRangeNumber($word)){
           array_push($stuct_token,"RN");
        }else if($wordtype->isLengthUnits($word)){
          array_push($stuct_token,"UN");
        }else if($wordtype->isColor($word)){
          array_push($stuct_token,"CL");
        }
        else{
           array_push($stuct_token,"__");
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
   $string = str_replace('.', '', $string);
   return $string;
   //return preg_replace('/[^A-Za-z0-9\-]/', ' ', $string);
 }



}



?>

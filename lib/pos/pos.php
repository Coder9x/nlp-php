<?php
/**
 *
 */
class pos
{

  var $structure = array();

  public function guess($sentence){
    $words = $this->sentence2Array($sentence);
    //$this->buildStructure($words);
    return $words;
  }


  private function buildStructure($words){
    $index = 0;
    foreach ($words as $word) {
      if($this->isNumber($word)){
        array_push($this->structure,"number");
      }else if($this->isNoun($words,$index)){
        array_push($this->structure,"noun");
      }else {
        array_push($this->structure,"?");
      }

      $index++;
    }
  }


 private function isNoun($words,$index){
   // fist word & has s
   if($index==0 && substr($words[0],-1)=='s'){
     return true;
   }


   return false;
 }

 private function isNumber($word){
   return is_numeric($word);
 }

 private function sentence2Array($sentence)
 {
   $words = array();
   $tmp_words = explode(", ",$sentence);
   foreach ($tmp_words as $word) {
     $cleaned_word = $this->clean($word);
     if(strlen($cleaned_word)>0){
       array_push($words,$cleaned_word);
     }
   }
   return $words;
 }

 private function clean($string) {
   $string = str_replace(' ', ',', $string);
   return preg_replace('/[^A-Za-z0-9\-]/', ' ', $string);
 }



}



?>

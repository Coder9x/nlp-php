<?php

class tokenization{

  var $punctuation = array(";",",","'","!");
  var $connectWords = array(" is "," are "," : ");

  public function getWordTokens($sentence){
    return explode(" ",$this->splitPunctuation($sentence));
  }

  public function getGroupTokens($sentence){
    return explode("//",$this->markPunctuation($sentence));
  }

  private function splitPunctuation($sentence){
    foreach ($this->punctuation as $value) {
      $sentence = str_replace($value," ".$value,$sentence);
    }
    return $sentence;
  }

  private function markPunctuation($sentence){
    foreach ($this->punctuation as $value) {
        $sentence = str_replace($value,$value."//",$sentence);
    }
    foreach ($this->connectWords as $value) {
        $sentence = str_replace($value,$value."//",$sentence);
    }
    return $sentence;
  }

}

?>

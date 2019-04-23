<?php
class place{

  var $directions = array ("N","S","W","E","NW","NE","SE","SW");

  public function getlengthUnits(){
    return $this->length_units;
  }

  public function isPlace($word){
    if($this->hasDirection($word)){
      return 2;
    }
    return 0;
  }


  private function hasDirection($word){
    $word = trim($word);
    foreach ($this->directions as $direct) {
      if(substr($word,0,2) == $direct || substr($word,0,3) == $direct){
        return true;
      }
    }
    return false;
  }


}

?>

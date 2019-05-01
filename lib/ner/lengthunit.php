<?php

class lengthunit{
  var $length_units = array ("m","dm","cm","mm");

  public function getlengthUnits(){
    return $this->length_units;
  }

  public function isLengthUnits($word){
    if(strlen($word)<3){
      foreach ($this->length_units as $unit) {
        if($word==$unit || $word == $unit."."){
          return true;
        }
      }

    }
    return false;
  }

}

?>

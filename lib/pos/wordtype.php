<?php

require('rangenumber.php');
require('lengthunit.php');

class wordtype {

  // number-number : RN
  public function isRangeNumber($word){
      $RN = new rangenumber;
      return $RN->isRangeNumber($word);
  }

  // units : UN
  public function isLengthUnits($word){
    $unit = new lengthunit;
    return $unit->isLengthUnits($word);
  }

  private function cleanWord(){
    $word = trim($word);

  }


}
?>

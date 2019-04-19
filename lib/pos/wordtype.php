<?php

require('rangenumber.php');
require('lengthunit.php');
require('color.php');


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

  // colors : CL
  public function isColor($word){
    $color = new color;
    return $color->isColor($word);
  }

  private function cleanWord(){
    $word = trim($word);

  }


}
?>

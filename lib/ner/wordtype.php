<?php

require('rangenumber.php');
require('singlenumber.php');
require('lengthunit.php');
require('color.php');
require('place.php');



class wordtype {

  // number-number : RN
  public function isRangeNumber($word){
      $RN = new rangenumber;
      return $RN->isRangeNumber($word);
  }

  // number : SN
  public function isSingleNumber($word){
    $sn = new singlenumber;
    return $sn->isSingleNumber($word);
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

  // colors : CL
  public function isPlace($word){
    $place = new place;
    return $place->isPlace($word);
  }


  private function cleanWord(){
    $word = trim($word);
  }


}
?>

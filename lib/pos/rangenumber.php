<?php


class rangenumber{


  

  // number-number : RN
  public function isRangeNumber($word){
    if(is_numeric(substr($word,0,1))){

      if(is_numeric(substr($word,-1))){

        if(strpos($word, '–')>0 || strpos($word, '-')>0) {

          return true;

        }
      }
    }
    return false;
  }

}


 ?>

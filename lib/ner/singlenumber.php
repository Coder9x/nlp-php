<?php

class singlenumber{

  // number : SN
  public function isSingleNumber($word){
    if(is_numeric($word)){
      return true;
    }
    return false;
  }


}



?>

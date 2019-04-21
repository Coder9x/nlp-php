<?php

class color{

  var $colors = array ("red","pink","gray","white","yellow","green","dark","brown","purple","pale");

  public function getColors(){
    return $this->colors;
  }

  public function isColor($word){
    $word = str_replace("ish","",$word);
    $word = str_replace("s","",$word);
    $word = str_replace("ly","",$word);
    $word = str_replace("-"," ",$word);
    $word = str_replace("-"," ",$word);

    foreach ($this->colors as $color) {
      $tmp_words = explode(" ",$word);

      foreach ($tmp_words as $tmp_word) {
        if($tmp_word==$color){
          return true;
        }
      }


    }

    return false;
  }


}



 ?>

<?php

class flow {

  var $percent_array_tags = array();

  public function sentenceFlow($array_tags){

    // build the array to store probability value
    for($index_tags=0;$index_tags<(sizeof($array_tags));$index_tags++){
      if(sizeof($array_tags[$index_tags])>0){
        $this->sortTags($array_tags[$index_tags]); // set value for array tags
      }else{
        array_push($this->sorted_array_tags,0);
      }
    }


    for($index_tags=0;$index_tags<(sizeof($array_tags));$index_tags++){
      // start with the second tags
      if($index_tags>0){
        // if the current tags has tag related to previous tags
        $this->updateProbabilty($array_tags[$index_tags],$array_tags[$index_tags-1],$index_tags,-1);
      }
      // do not check the last one
      if($index_tags<(sizeof($array_tags)-1)){
          // if the current tags has tag related to previous tags
          $this->updateProbabilty($array_tags[$index_tags],$array_tags[$index_tags+1],$index_tags,+1);
      }
    }



   print_r($this->sorted_array_tags);

  }

  private function updateProbabilty($curr_tags,$prv_tags,$curr_index,$offset){
    for($i=0;$i<sizeof($curr_tags);$i++){
      for($z=0;$z<sizeof($prv_tags);$z++){

        if($curr_tags[$i]==$prv_tags[$z]){
          // fomular to update the related
          $p_curr = $this->sorted_array_tags[$curr_index][$i];
          $p_remain = 100-$p_curr;
          $p_prv = $this->sorted_array_tags[$curr_index+$offset][$z];
          $p_plus = ($p_prv*$p_remain/100);
          $this->sorted_array_tags[$curr_index][$i]=$p_curr+$p_plus;

        }
      }
    }

  }

  private function sortTags($tags){
      $sorted_tags = array();
      $size = sizeof($tags);
      foreach ($tags as $tag) {
        array_push($sorted_tags,100/$size);
      }
      array_push($this->sorted_array_tags,$sorted_tags);
  }




}
?>

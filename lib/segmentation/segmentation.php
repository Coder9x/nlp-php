<?php
/*****************************************
* sentence boundary disambiguation
*****************************************/

/*

The text is terminated by a period question mark,
or exclamation mark

The period is not preceded
by an abbreviation or followed by a digit

SHOULD REPLACE ALL QUESTIONS MARKS AND ...

*/


class segmentation{

  var $inParentheses=false;


  /* split a text to an array of sentences
  they are sperated by ending periods */
  public function split2Sentence($text){
    $words = $this->split2Word($text);
    $words = $this->markWrongPeriod($words);
    $sentences = explode(". ",$this->words2Text($words));
    $sentences = $this->removeMarks($sentences);

    $sub_sentences = array();
    foreach ($sentences as $sentence) {
      $subs = explode("; ",trim($sentence));
      array_push($sub_sentences,$subs);
    }

    return $sub_sentences;
  }

  /* split a text to an array of words
  the words are sperated by blank spaces*/
  private function split2Word($text){
    return explode(" ",$text);
  }


  /* marks a word which contains a period
  but it is not the ending period*/
  private function markWrongPeriod($words){
    $len = count($words);
    for($i=0;$i<$len;$i++){


      //Skip all words in (  here  )
      if (strpos($words[$i], '(') !== false) {
        $this->inParentheses= true;
      }

      if (strpos($words[$i], ')') !== false) {
        $this->inParentheses= false;
      }

      if($this->inParentheses == true){
        $words[$i] = str_replace(".",".//",$words[$i]);
        
      }else{

      if (substr($words[$i],-1)=='.') { // end with '.'

          if(($i+1)<$len){
          //echo "words:".$words[$i];
          // if the next word is not capital -> wrong ending period
          if(!$this->isCapital($words[$i+1])){
              $words[$i] = str_replace(".",".//",$words[$i]);
              //echo "-->"."is captial next";
            }
          else if($this->isNameInital($words[$i])==true){ //if it is intial
            $words[$i] = str_replace(".",".//",$words[$i]);
            //echo "-->"."is name intial";

            // if it is an abbrev, so it is not period
          }else if($this->isAbbrev($words[$i])){
            $words[$i] = str_replace(".",".//",$words[$i]);
            //echo "-->"."is Abbrev";

          }
          //echo "<br/>";
          }
      }
      }

      $words[$i]=trim($words[$i]);

    }
    return $words;
  }

  /* removes the marks of words*/
  private function removeMarks($words){
    for($i=0;$i<count($words);$i++){
      $words[$i] = str_replace(".//",".",$words[$i]);
    }
    return $words;
  }

  /* checks if the a word is in abbreviations*/
  private function isAbbrev($word){

    require($_SERVER["DOCUMENT_ROOT"].'/nlp/nlp-php/lib/database/dbconfig.php');
    $sql = "SELECT `id_word` FROM `dictionary_abbreviations` WHERE `id_word` LIKE '".$word."'";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
      return true;
    }else{
      return false;
    }

  }

  /* checks if the a word is intial for names
  *  the previous letter is capital
  */
  private function isNameInital($word){
    //echo "intial: ".$word."<br/>";
    if (ctype_upper(substr($word,-2,-1))) {
      return true;
    }else{
      return false;
    }
  }

  /* convert words to a long text*/
  private function words2Text($words){
    $text = "";
    foreach($words as &$word){
      $text=$text." ".$word;
    }
    return $text;
  }

  /* check if the word after the period is capital */
  private function isCapital($word){
    // get first letter of the word
    $first_letter =  substr($word,0,1);
    if (ctype_upper($first_letter) || // is capital
    is_numeric($first_letter) // is number
    ){
      return true;
    }else{
      return false;
    }
  }



}




?>

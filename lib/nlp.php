<?php
require($_SERVER["DOCUMENT_ROOT"].'/nlp/nlp-php/lib/database/dbconfig.php');
require($_SERVER["DOCUMENT_ROOT"].'/nlp/nlp-php/lib/segmentation/segmentation.php');
require($_SERVER["DOCUMENT_ROOT"].'/nlp/nlp-php/lib/tokenization/tokenization.php');
require($_SERVER["DOCUMENT_ROOT"].'/nlp/nlp-php/lib/ner/ner.php');
require($_SERVER["DOCUMENT_ROOT"].'/nlp/nlp-php/lib/pos/pos.php');


class nlp {

  /**************************************************
  * breaking the text apart into separate sentences
  **************************************************/
  public function segmentation($paragraph){
    $segmentation = new segmentation;
    $result = $segmentation->split2Sentence($paragraph);
    return $result;
  }


  public function ner($tokens){
    $ner = new ner;
    return $ner->define($tokens);
  }



  /**
  * input: a string as a sentence
  * output: array of words
  */
  function tokenize($sentence,$option){
    $tokenization = new tokenization;
    if($option=="word" || $option=="w"){
    return $tokenization->getWordTokens($sentence);
    }
    return $tokenization->getGroupTokens($sentence);

  }

  /**
  * input: a string as a sentence
  * output: array of structure
  */
  function pos($sentence){
    $pos = new pos;
    return $pos->construct($sentence);
  }

}

?>

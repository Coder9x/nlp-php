<?php
require($_SERVER["DOCUMENT_ROOT"].'/nlp/nlp-php/lib/database/dbconfig.php');
require($_SERVER["DOCUMENT_ROOT"].'/nlp/nlp-php/lib/structures/structures.php');
require($_SERVER["DOCUMENT_ROOT"].'/nlp/nlp-php/lib/segmentation/segmentation.php');


class nlp {

  /**************************************************
  * breaking the text apart into separate sentences
  **************************************************/
  public function segmentation($paragraph){
    $starttime = microtime(true);


    $segmentation = new segmentation;
    $result = $segmentation->split2Sentence($paragraph);

    $endtime = microtime(true);
    $timediff = $endtime - $starttime;


    echo "Speed: ".round($timediff,5)."<br/>";

    return $result;

  }


  /*
  * input: a long string as a paragraph
  * output: array of sentences
  */
  function segment($paragraph){
    $tokenizers = new tokenizers;
    return $tokenizers->split2Sentence($paragraph);
  }

  /**
  * input: a string as a sentence
  * output: array of words
  */
  function tokenize($sentence){
    $tokenizers = new tokenizers;
    return $tokenizers->split2Word($sentence);
  }

  /**
  * input: a string as a sentence
  * output: array of structure
  */
  function structure($sentence){
    $structure = new structure;
    return $structure->construct($sentence);
  }

}

?>

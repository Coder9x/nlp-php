<?php

require('lib/database/dbconfig.php');
require('lib/nlp.php');

$sql = "SELECT *  FROM `edb_eflora` WHERE `id` = ".$_GET['id'];
$next_id = $_GET['id']+1;


$result = $connection->query($sql);
$curr = 0;
$stop = 1;
$txt = "";
if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()){
        $txt =  $row['text'];
      }
}


$nlp = new nlp;
$array = $nlp->tokenize($txt,"w");

$array = array_unique($array);


$cleaned_arr = array();
$in = 0;

$stopwords = array("a", "about", "above", "above", "across", "after", "afterwards", "again", "against", "all", "almost", "alone", "along", "already", "also","although","always","am","among", "amongst", "amoungst", "amount", "an", "and", "another", "any","anyhow","anyone","anything","anyway", "anywhere", "are", "around", "as", "at", "back","be","became", "because","become","becomes", "becoming", "been", "before", "beforehand", "behind", "being", "below", "beside", "besides", "between", "beyond", "bill", "both", "bottom","but", "by", "call", "can", "cannot", "cant", "co", "con", "could", "couldnt", "cry", "de", "describe", "detail", "do", "done", "down", "due", "during", "each", "eg", "either", "eleven","else", "elsewhere", "empty", "enough", "etc", "even", "ever", "every", "everyone", "everything", "everywhere", "except", "few", "fifteen", "fify", "fill", "find", "fire", "first", "for", "former", "formerly", "forty", "found", "from", "front", "full", "further", "get", "give", "go", "had", "has", "hasnt", "have", "he", "hence", "her", "here", "hereafter", "hereby", "herein", "hereupon", "hers", "herself", "him", "himself", "his", "how", "however", "hundred", "ie", "if", "in", "inc", "indeed", "interest", "into", "is", "it", "its", "itself", "keep", "last", "latter", "latterly", "least", "less", "ltd", "made", "many", "may", "me", "meanwhile", "might", "mill", "mine", "more", "moreover", "most", "mostly", "move", "much", "must", "my", "myself", "name", "namely", "neither", "never", "nevertheless", "next", "no", "nobody", "none", "noone", "nor", "not", "nothing", "now", "nowhere", "of", "off", "often", "on", "once", "only", "onto", "or", "other", "others", "otherwise", "our", "ours", "ourselves", "out", "over", "own","part", "per", "perhaps", "please", "put", "rather", "re", "same", "see", "seem", "seemed", "seeming", "seems", "serious", "several", "she", "should", "show", "side", "since", "sincere", "so", "some", "somehow", "someone", "something", "sometime", "sometimes", "somewhere", "still", "such", "system", "take", "than", "that", "the", "their", "them", "themselves", "then", "thence", "there", "thereafter", "thereby", "therefore", "therein", "thereupon", "these", "they", "thickv", "thin", "third", "this", "those", "though", "through", "throughout", "thru", "thus", "to", "together", "too", "top", "toward", "towards", "twelve", "twenty", "un", "under", "until", "up", "upon", "us", "very", "via", "was", "we", "well", "were", "what", "whatever", "when", "whence", "whenever", "where", "whereafter", "whereas", "whereby", "wherein", "whereupon", "wherever", "whether", "which", "while", "whither", "who", "whoever", "whole", "whom", "whose", "why", "will", "with", "within", "without", "would", "yet", "you", "your", "yours", "yourself", "yourselves", "the");

foreach ($array as $value) {

  $tmp_arr = explode("-",$value);
  foreach ($tmp_arr as $tmp) {
    array_push($array,$tmp);
  }

  $tmp_arr = explode("-",$value);
  foreach ($tmp_arr as $tmp) {
    array_push($array,$tmp);
  }

  $tmp = trim($tmp);
  $tmp = str_replace("-"," ",$tmp);
  $tmp = str_replace("-"," ",$tmp);
  $tmp = str_replace(' ', '', $tmp);
  $tmp =  preg_replace('/[^A-Za-z0-9\-]/', ' ', $value);


  if(!is_numeric($tmp) && strlen($tmp)>0 ){
    $inarr = false;

    foreach ($stopwords as $w) {
      if(strtolower($value)==strtolower($w)){
        $inarr = true;
        break;
      }
    }
    if(!$inarr){
      $cleaned_arr[$in] = $tmp;
      $in++;
    }
  }
}

//print_r($cleaned_arr);

foreach ($cleaned_arr as $value) {


  $sql = "SELECT *  FROM `entries` WHERE `word` LIKE '".$value."'";

  if(substr($value,-1)=='s'){
    $value_no_s = substr($value,0,-1);
    $sql = "SELECT *  FROM `entries` WHERE `word` LIKE '".$value."' OR `word` LIKE '".$value_no_s."'";
    //echo $sql."<br/>";
  }


  $result = $connection->query($sql);
  if ($result->num_rows > 0) {
        $w = "";
        $wt = array();
        $def = array();
        while($row = $result->fetch_assoc()){
          $w = $row['word'];
          array_push($wt,$row['wordtype']);
          array_push($def,$row['definition']);

          //echo $w." ".$wt." <br/>";

        }
        $wt = array_unique($wt);

        $wt_text="";
        foreach ($wt as $val) {
          $wt_text = $wt_text." ".$val;
        }

        $def_text="";
        foreach ($def as $de) {
          $def_text = $def_text."| ".$de;
        }

        $w = strtolower($w);


        // add to dictionary
       $sql = "INSERT INTO `rhododendron_dictionary`(`word`, `wordtype`, `definition`) VALUES ('".$w."','".trim($wt_text)."','".trim($def_text)."')";
       $result = $connection->query($sql);

  }else{

        $tmp = trim($value);
        $tmp = str_replace("-"," ",$tmp);
        $tmp = str_replace("-"," ",$tmp);
        $tmp = str_replace(' ', '', $tmp);
        $tmp = str_replace(' ', '', $tmp);
        $tmp =  preg_replace('/[^A-Za-z0-9\-]/', ' ', $tmp);

        if(!is_numeric($tmp)){
          // add to dictionary
          $sql = "INSERT INTO `unkown_word`(`id`) VALUES ('".$tmp."')";
          $result = $connection->query($sql);
       }
  }

}

if($next_id<4531){
  echo "<script type='text/javascript'>";
  echo "window.location.href = 'http://localhost/nlp/nlp-php/dictionary.php?id=".$next_id."';";
  echo "</script>";
}

?>

<?php

class tokenizers{

  /* split a text to an array of words
  the words are sperated by blank spaces*/
  public function split2Word($text){
    return explode(" ",$text);
  }

  /* split a text to an array of sentences
  they are sperated by ending periods */
  public function split2Sentence($text){

    $words = $this->split2Word($text);
    $words = $this->markWrongPeriod($words);
    $words = explode(". ",$this->words2Text($words));
    $words = $this->removeMarks($words);
    return $words;
  }

  /* marks a word which contains a period
  but it is not the ending period*/
  private function markWrongPeriod($words){
    for($i=0;$i<count($words);$i++){
      if (strpos($words[$i], '.') !== false) { // contain '.'

          if($this->isNameInital($words[$i])==true){ //if it is intial
                $words[$i] = str_replace(".",".//",$words[$i]);
          }else if($this->isAbbrev($words[$i])){ // if it is abbrev, so it is not period
                $words[$i] = str_replace(".",".//",$words[$i]);
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
    $sql = "SELECT `id_word` FROM `dictionary_abbreviations` WHERE `id_word` LIKE '%".$word."%'";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
          return true;
    }else{
          return false;
    }

  }

  /* checks if the a word is intial for names*/
  private function isNameInital($word){
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

}


/*echo "Test Tokenizers <br/>";
$test_token = new tokenizers;
$sentence = $test_token->split2Sentence("
Shrubs, to 3(-5) m, usually not rhizomatous. Stems: bark smooth to vertically furrowed, shredding; twigs scattered, multicellular eglandular-hairy (hairs unbranched), otherwise glabrous or moderately unicellular-hairy. Leaves decid-uous; petiole unicellular- and stipitate-glandular-hairy; blade ovate to obovate, 4-7.7(-9.4) × 1.2-2.5(-3.3) cm, thin, membranous, margins entire, plane, ciliate, eglandular-hairy, apex acute to obtuse, often mucronate, abaxial surface glabrous or unicellular-hairy, adaxial surface usually scattered eglandular-hairy, usually also unicellular-hairy. Floral bud scales glabrous or glabrate abaxially, margins unicellular-ciliate. Inflorescences 6-7-flowered; bracts similar to bud scales. Pedicels 4-12 mm, eglandular- and/or stipitate-glandular-hairy, otherwise glabrous or moderately unicellular-hairy. Flowers opening before or with leaves, erect to horizontal, very fragrant; calyx lobes 0.1-3 mm, scattered eglandular-hairy and/or stipitate-glandular-hairy, otherwise sparsely to moderately unicellular-hairy, margins eglandular-hairy; corolla white, sometimes pink-tinged, with contrasting yellow blotch on upper lobe, funnelform, 25-42 mm, scattered stipitate-glandular-hairy (hairs often continuing in lines up lobes), otherwise sparsely to moderately unicellular-hairy on outer surface, petals connate, lobes 9-21 mm, tube usually ± gradually expanded into lobes, 15-31 mm (longer than lobes); stamens 5, much exserted, ± unequal, 37-69 mm. Capsules borne on erect pedicels, 14-22 × 3-4 mm, sparsely to moderately multicellular eglandular-hairy, otherwise moderately to densely unicellular-hairy. Seeds without distinct tails; testa expanded, dorsiventrally flattened, ± loose. 2n = 26. Flowering late spring-summer. Coniferous forests, alpine thickets, stream banks, seeps on rock outcrops; 800-3500 m; Alta., B.C.; Colo., Idaho, Mont., Oreg., Wash. Rhododendron albiflorum is especially distinctive due to its axillary, white, somewhat pendulous, and nearly actinomorphic flowers, and it is placed in the monotypic subg. Candidastrum (Sleumer) Philipson & Philipson (W. R. Philipson and M. N. Philipson 1986). It is occasionally used as an ornamental. The disjunct population in Colorado has somewhat smaller calyx lobes and corollas and shorter stamens; it is sometimes recognized as var. warrenii (M. A. Lane et al. 1993). This variety is not recognized here because of the extent of morphological overlap between that population and those of the Pacific Northwest. Flowering late spring-summer. Coniferous forests, alpine thickets, stream banks, seeps on rock outcrops; 800-3500 m; Alta., B.C.; Colo., Idaho, Mont., Oreg., Wash. Rhododendron albiflorum is especially distinctive due to its axillary, white, somewhat pendulous, and nearly actinomorphic flowers, and it is placed in the monotypic subg. Candidastrum (Sleumer) Philipson & Philipson (W. R. Philipson and M. N. Philipson 1986). It is occasionally used as an ornamental. The disjunct population in Colorado has somewhat smaller calyx lobes and corollas and shorter stamens; it is sometimes recognized as var. warrenii (M. A. Lane et al. 1993). This variety is not recognized here because of the extent of morphological overlap between that population and those of the Pacific Northwest. Shrubs, to 3(-5) m, usually not rhizomatous. Stems: bark smooth to vertically furrowed, shredding; twigs scattered, multicellular eglandular-hairy (hairs unbranched), otherwise glabrous or moderately unicellular-hairy. Leaves decid-uous; petiole unicellular- and stipitate-glandular-hairy; blade ovate to obovate, 4-7.7(-9.4) × 1.2-2.5(-3.3) cm, thin, membranous, margins entire, plane, ciliate, eglandular-hairy, apex acute to obtuse, often mucronate, abaxial surface glabrous or unicellular-hairy, adaxial surface usually scattered eglandular-hairy, usually also unicellular-hairy. Floral bud scales glabrous or glabrate abaxially, margins unicellular-ciliate. Inflorescences 6-7-flowered; bracts similar to bud scales. Pedicels 4-12 mm, eglandular- and/or stipitate-glandular-hairy, otherwise glabrous or moderately unicellular-hairy. Flowers opening before or with leaves, erect to horizontal, very fragrant; calyx lobes 0.1-3 mm, scattered eglandular-hairy and/or stipitate-glandular-hairy, otherwise sparsely to moderately unicellular-hairy, margins eglandular-hairy; corolla white, sometimes pink-tinged, with contrasting yellow blotch on upper lobe, funnelform, 25-42 mm, scattered stipitate-glandular-hairy (hairs often continuing in lines up lobes), otherwise sparsely to moderately unicellular-hairy on outer surface, petals connate, lobes 9-21 mm, tube usually ± gradually expanded into lobes, 15-31 mm (longer than lobes); stamens 5, much exserted, ± unequal, 37-69 mm. Capsules borne on erect pedicels, 14-22 × 3-4 mm, sparsely to moderately multicellular eglandular-hairy, otherwise moderately to densely unicellular-hairy. Seeds without distinct tails; testa expanded, dorsiventrally flattened, ± loose. 2n = 26. Flowering late spring-summer. Coniferous forests, alpine thickets, stream banks, seeps on rock outcrops; 800-3500 m; Alta., B.C.; Colo., Idaho, Mont., Oreg., Wash. Rhododendron albiflorum is especially distinctive due to its axillary, white, somewhat pendulous, and nearly actinomorphic flowers, and it is placed in the monotypic subg. Candidastrum (Sleumer) Philipson & Philipson (W. R. Philipson and M. N. Philipson 1986). It is occasionally used as an ornamental. The disjunct population in Colorado has somewhat smaller calyx lobes and corollas and shorter stamens; it is sometimes recognized as var. warrenii (M. A. Lane et al. 1993). This variety is not recognized here because of the extent of morphological overlap between that population and those of the Pacific Northwest. Flowering late spring-summer. Coniferous forests, alpine thickets, stream banks, seeps on rock outcrops; 800-3500 m; Alta., B.C.; Colo., Idaho, Mont., Oreg., Wash. Rhododendron albiflorum is especially distinctive due to its axillary, white, somewhat pendulous, and nearly actinomorphic flowers, and it is placed in the monotypic subg. Candidastrum (Sleumer) Philipson & Philipson (W. R. Philipson and M. N. Philipson 1986). It is occasionally used as an ornamental. The disjunct population in Colorado has somewhat smaller calyx lobes and corollas and shorter stamens; it is sometimes recognized as var. warrenii (M. A. Lane et al. 1993). This variety is not recognized here because of the extent of morphological overlap between that population and those of the Pacific Northwest.");
print_r($sentence);


*/

?>

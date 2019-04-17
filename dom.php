<?php
// Get all link course
include_once('simple_html_dom.php');
require($_SERVER["DOCUMENT_ROOT"].'/nlp/nlp-php/lib/database/dbconfig.php');


// Create DOM from URL or file
for($page=1;$page<6;$page++){
$src = 'http://www.efloras.org/browse.aspx?flora_id=2&start_taxon_id=128386&page='.$page;
$html = file_get_html($src);

$links = array();
$titles = array();

$i=0;
// Find all links
foreach($html->find('a') as $element){
        $thelink = $element->href;
        if (strpos($thelink, 'florataxon.aspx') !== false) {
            if($i>1){
            //echo $element->plaintext."<br/>";
            //echo  "http://www.efloras.org/".$thelink. '<br/>';
            array_push($links,"http://www.efloras.org/".$thelink);
            array_push($titles,$element->plaintext);

            }
            $i++;

        }
        //echo $element->plaintext . '<br>';
}


// Display
$count = 1;
$ititle=0;
foreach ($links as $link) {
  //echo $link;
  $html = file_get_html($link);
  $element = $html->find("span[id='lblTaxonDesc']")[0];
  //echo $element->find('b')[0]->plaintext."<br/>";
  $taxon = $titles[$ititle];
  $ititle++;

  $content = "";
  $syn = "";
  $info = $element->find('p');
  $line=1;
  foreach ($info as $text) {
    if(strlen(trim($text->plaintext))>0){
    //echo $line."<br/>";
    //echo $text->plaintext."<br/>"; // info
      if($line==5){
        $syn = $text->plaintext;
      }
      if($line>5){
        $content = $content.$text->plaintext;
      }
    }
    $line++;
  }

  //echo $taxon."<br/>";
  //echo $content."<br/>";
  //echo $syn."<br/>";



  $sql = "INSERT INTO `edb_eflora`(`taxon`, `synonym`, `text`) VALUES ('".$taxon."','".$syn."','".$content."')";
  $result = $connection->query($sql);


  $count++;
  //echo "<br/>";
}


}

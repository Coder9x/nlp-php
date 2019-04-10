<?php
// Get all link course
include_once('simple_html_dom.php');


// Create DOM from URL or file
$src = 'http://www.efloras.org/browse.aspx?flora_id=1&start_taxon_id=128386';
$html = file_get_html($src);

// Find all links
foreach($html->find('a') as $element){
        $thelink = $element->href;
        echo  $thelink. '<br/>';
        //echo $element->plaintext . '<br>';

}

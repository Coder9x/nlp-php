<?php
require($_SERVER["DOCUMENT_ROOT"].'/nlp/nlp-php/lib/database/dbconfig.php');
require($_SERVER["DOCUMENT_ROOT"].'/nlp/nlp-php/lib/tokenizers/tokenizers.php');
require($_SERVER["DOCUMENT_ROOT"].'/nlp/nlp-php/lib/structures/structures.php');


class nlp {

  /**
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

echo "Test NLP.<br/>";
echo "<br/><br/>";

$test_nlp = new nlp;
$result = $test_nlp->segment("

Shrub or small tree to 3m. Twigs: rounded, green, finely covered in small brown scales, quickly glabrescent; internodes 1–4cm. Leaves in loose pseudowhorls 10–20 together. Blade 18–32 x 4–6mm, narrowly elliptic to linear, often slightly broader in the distal ½; apex broadly pointed; margin entire, strongly recurved, often completely rolled when dry; base tapering; sparsely scaly and quickly glabrescent above, sparsely but more persistently scaly below. Scales sub-circular or shallowly lobed, often with large centres. Mid-vein deeply impressed above, thickly prominent between the revolute parts of the lamina beneath; lateral veins obscure. Petiole 3–8 x 1–1.5mm, grooved above, laxly scaly. Flower buds to 10 x 7mm, ovoid-conical, with the erect subulate points of the bracts standing out, dark-red. Outer bracts keeled, apiculate, inner ones ovate with subulate acumen, the margins densely scaly, minutely hairy or glabrous outside. Bracteoles c.10 x 0.5mm, linear, glabrous, irregularly incised distally. Inflorescence of 2–4-flowered open umbels. Flowers half-hanging to hanging, pink with a violet tinge, without scent. Pedicels 16–20 x c.1mm, densely patently long-hairy, laxly scaly with fragile scales. Calyx c.3mm in diameter, disc-like, weakly angled, sometimes becoming reflexed, patently hairy outside and with a few scales. Corolla 20–25 x 30–34mm, broadly tubular below, sub-campanulate, dilated towards the mouth; tube 18–20 x 6–8 x 9–10mm, sub-densely covered with soft, white, patent hairs and almost without scales, although often with small clusters of scales at the lobe junctions; lobes 13–15 x 8–10mm, broadly obovate-spathulate, hairy outside, glabrous inside, not, or overlapping to c.½. Stamens at first clustered on the lower side of the mouth, becoming irregularly spreading, exserted to c.7mm; filaments linear, patently hairy for the lower ¼–1⁄3, glabrous distally; anthers 2–2.5 x c.1mm, broadly oblong, each cell with a small basal apiculus. Disc prominent, glabrous or with hairs on the upper margin. Ovary c.5 x 3mm, ovoid, densely patently white-hairy, and with scattered brown scales, abruptly contracted distally; style with a few hairs at the base otherwise glabrous, c.12mm, expanding to c.20mm, lying on the lower side of the tube; stigma rounded, bright red, becoming exserted to c.8mm. Fruit 12 x 6mm, obovoid-cylindric, dark purple, densely short-hairy and laxly scaly. Seeds 1.8mm, without tails 0.8mm, the longest tail 0.6mm.
");


foreach($result as $sen){
  echo "".$sen."<br/>";
  $struct = $test_nlp->structure($sen);

  if(strlen($struct)>0){
      echo "".$struct."";
  }else{
     echo "<mark>{unstructable}</mark>";
  }

  echo "<br/><br/>";
}



?>
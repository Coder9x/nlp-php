<?php
require('lib/nlp.php');

echo "Test NLP.<br/>";
echo "<br/><br/>";

$test_nlp = new nlp;
$result = $test_nlp->segmentation("Shrubs or trees, to 6 m, usually not rhizomatous. Stems: bark smooth to vertically furrowed, shredding; twigs glabrous or, very rarely, sparsely, widely scattered, unicellular and multicellular eglandular-hairy. Leaves decid-uous; petiole glabrous or multicellular eglandular-hairy; blade ovate to obovate, 3-8(-10.5) × 1.3-3.5 cm, thin, chartaceous, margins entire, plane, ciliate, eglandular-hairy, apex acute to obtuse, often mucronate, abaxial surface glabrous, (sometimes glaucous), adaxial surface glabrous, (lustrous). Floral bud scales usually glabrous abaxially, margins unicellular-ciliate. Inflorescences 3-7-flowered; bracts similar to bud scales. Pedicels 6-21 mm, glabrous or stipitate-glandular-hairy, sometimes also unicellular-hairy. Flowers opening after leaves, erect to horizontal, very fragrant; calyx lobes 0.8-6(-9) mm, surfaces and margins scattered, stipitate-glandular- and/or, sometimes, eglandular-hairy; corolla white or, sometimes, light pink (contrasting with dark pink to red style and filaments), without blotch on upper lobe, funnelform, 30-55 mm, stipitate-glandular-hairy (hairs continuing in lines up lobes), otherwise glabrous or sparsely unicellular-hairy on outer surface, petals connate, lobes 10-24 mm, tube ± gradually expanded into lobes, 20-37 mm (equaling or much longer than lobes); stamens 5, much exserted, ± unequal, 44-82 mm. Capsules borne on erect pedicels, 8-17 × 4.5-8 mm, ± densely multicellular stipitate-glandular-hairy, sometimes also sparsely unicellular-hairy. Seeds with-out distinct tails; testa not dorsiventrally flattened, usually ± loose. 2n = 26. Flowering late spring-summer. Stream banks, rocky streamsides, heath balds, swampy woods or bogs; 90-1500 m; Ala., Ga., Ky., Md., N.C., Pa., S.C., Tenn., Va., W.Va. Rhododendron arborescens is most closely related to R. viscosum, as evidenced by their glabrous floral bud scales and flowers that appear after the leaves have expanded (K. A. Kron 1993). It can be distinguished by its glabrous branchlets, red style and filaments (which contrast with the white corollas), and distinctive seeds that lack loose, expanded testae. These two species occasionally hybridize; hybrids with R. cumberlandense also are known.");

//print_r($result);


echo "<dl>";

foreach($result as $sen){
  $i=0;
  foreach ($sen as $sub) {
    if($i==0){
      echo "<dt>".$sub."<br/><mark>".$test_nlp->structure($sub)."</mark><dt>";

    }else{
      echo "<dd>".$sub."<br/><mark>".$test_nlp->structure($sub)."</mark><dd>";
    }
    $i++;
  }
  $i=0;
  echo "<br/>";
}

echo "</dl>";


?>

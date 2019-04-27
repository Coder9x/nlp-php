<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width">
    <title> User View </title>
    <link rel="stylesheet" href="Treant.css">
    <link rel="stylesheet" href="no-parent.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

</head>
<body style="margin:10px;">
    <script src="vendor/raphael.js"></script>
    <script src="Treant.js"></script>





<?php
require('lib/nlp.php');
require('lib/database/dbconfig.php');


echo "<select id='taxon'>";

$sql = "SELECT *  FROM `edb_eflora`";
$result = $connection->query($sql);
$curr = 0;
$stop = 900;

$input = "";


if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()){
        $curr++;
        if($curr<=$stop){
        //echo $row['text']."<br/>";
        if($row['id']==$_GET['id']){
          echo "<option id='".$row['id']."' selected>".$row['taxon']."</option>";

        }else{
          echo "<option id='".$row['id']."'>".$row['taxon']."</option>";
        }

        }

      }
}

$sql = "SELECT *  FROM `edb_eflora` WHERE `id`='".$_GET["id"]."'";
$result = $connection->query($sql);

$input = "";

if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()){
        $input = $row['text'];
        break;
        }
}


echo "</select> <br/><br/>";

echo $input;

echo "    <div  id='OrganiseChart1'></div>";

echo "

<script>

var config = {
        container: '#OrganiseChart1',
        rootOrientation:  'WEST', // NORTH || EAST || WEST || SOUTH
        hideRootNode: true,
        // levelSeparation: 30,
        siblingSeparation:   40,
        subTeeSeparation:    30,

        connectors: {
            type: 'curve'
        },
        node: {
            HTMLclass: 'nodeExample1'
        }
    },
    root = {},

    ";



    $test_nlp = new nlp;
    $result = $test_nlp->segmentation($input);

    //print_r($result);


    $starttime = microtime(true);
    $object = "";

    $name = array();

    foreach($result as $sen){
      $i=0;
      foreach ($sen as $sub_sen) {
        if($i==0){

          $tokens = $test_nlp->tokenize($sub_sen,"g");

          $idname = strtolower(substr($sub_sen,0,3));
          $idname =   str_replace(" ","k",$idname);
          $idname =   str_replace(".","p",$idname);
          $idname = generateRandomString(3).$idname;

          $ners = $test_nlp->ner($tokens);
          $str_ner = "";
          $itkn = 0;
          //$str_tkn="";
          foreach ($ners as $ner) {
            //$str_tkn=$str_tkn."[".$tokens[$itkn++]."]";
            $str_ner= $str_ner."[";
            foreach ($ner as $p) {
              $str_ner = $str_ner." ".$p;
            }
            $str_ner= $str_ner."]";
          }


          array_push($name,$idname);
          echo $idname." ";
          echo " = {
              parent: root,
              text:{
                  name: '',
                  title: '".$sub_sen."',
                  contact: '".$str_ner."'
              },
              stackChildren: true,
              HTMLid: '".$idname."'
          },
          ";




        }else{


          $tokens = $test_nlp->tokenize($sub_sen,"g");
          $subname = generateRandomString(3).$idname;

          $ners = $test_nlp->ner($tokens);
          $str_ner = "";
          $itkn = 0;
          //$str_tkn="";
          foreach ($ners as $ner) {
            //$str_tkn=$str_tkn."[".$tokens[$itkn++]."]";
            $str_ner= $str_ner."[";
            foreach ($ner as $p) {
              $str_ner = $str_ner." ".$p;
            }
            $str_ner= $str_ner."]";
          }

          array_push($name,$subname);
          echo $subname." ";
          echo " = {
              parent: ".$idname.",
              text:{
                  name: '',
                  title: '".$sub_sen."',
                  contact: '".$str_ner."'
              },
              stackChildren: true,
              HTMLid: '".$subname."'
          },
          ";



        }
        $i++;
      }
      $i=0;
    }




    echo "



    ALTERNATIVE = [
        config,
        root,
        ";

        foreach ($name as $n) {
          echo $n.",
          ";
        }

        echo "
    ];
    new Treant(ALTERNATIVE);
</script>



";


function generateRandomString($length = 3) {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

$endtime = microtime(true);
$timediff = $endtime - $starttime;


echo "Speed: ".round($timediff,5)."<br/>";



?>


<script>

$( "#taxon" ).change(function() {
    var str = "";
    str = $(this).children(":selected").attr("id");
    window.location.href = 'http://localhost/nlp/nlp-php/userview.php?id='+str;
    //alert(str);

});


</script>

</body>
</html>

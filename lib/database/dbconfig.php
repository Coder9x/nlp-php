<?php

$DBhost = "localhost";
$DBuser = "root";
$DBpass = "";
$DBname = "nlp";

try {

    $DBcon = new PDO("mysql:host=$DBhost;dbname=$DBname", $DBuser, $DBpass);
    $DBcon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $ex) {
    die($ex->getMessage());
}

$connection = mysqli_connect($DBhost,$DBuser,$DBpass,$DBname) or die("Error " . mysqli_error($connection));

?>

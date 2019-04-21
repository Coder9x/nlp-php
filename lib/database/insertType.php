<?php
require('dbconfig.php');

$sql = "INSERT INTO `type`(`tid`, `name`)".
" VALUES (1,'word')";
$connection->query($sql);

$sql = "INSERT INTO `type`(`tid`, `name`)".
" VALUES (2,'single number')";
$connection->query($sql);

$sql = "INSERT INTO `type`(`tid`, `name`)".
" VALUES (3,'range number')";
$connection->query($sql);

$sql = "INSERT INTO `type`(`tid`, `name`)".
" VALUES (4,'color')";
$connection->query($sql);

$sql = "INSERT INTO `type`(`tid`, `name`)".
" VALUES (5,'length unit')";
$connection->query($sql);

echo "Done! Please check the database";

?>

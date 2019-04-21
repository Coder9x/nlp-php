<?php
require('dbconfig.php');

$sql = "INSERT INTO `morpheme`(`mid`, `name`, `synonyms`, `abbreviation`, `acronym`)".
"VALUES (1,'Synonyms','','','')";
$connection->query($sql);

$sql = "INSERT INTO `morpheme`(`mid`, `name`, `synonyms`, `abbreviation`, `acronym`)".
"VALUES (2,'Subgenus','','','')";
$connection->query($sql);

$sql = "INSERT INTO `morpheme`(`mid`, `name`, `synonyms`, `abbreviation`, `acronym`)".
"VALUES (3,'Geographic Distribution','','','')";
$connection->query($sql);

$sql = "INSERT INTO `morpheme`(`mid`, `name`, `synonyms`, `abbreviation`, `acronym`)".
"VALUES (4,'Elevation','','','')";
$connection->query($sql);

$sql = "INSERT INTO `morpheme`(`mid`, `name`, `synonyms`, `abbreviation`, `acronym`)".
"VALUES (5,'Habit','','','')";
$connection->query($sql);

$sql = "INSERT INTO `morpheme`(`mid`, `name`, `synonyms`, `abbreviation`, `acronym`)".
"VALUES (6,'Flowering Time','','','')";
$connection->query($sql);

$sql = "INSERT INTO `morpheme`(`mid`, `name`, `synonyms`, `abbreviation`, `acronym`)".
"VALUES (7,'Flower Color','','','')";
$connection->query($sql);

$sql = "INSERT INTO `morpheme`(`mid`, `name`, `synonyms`, `abbreviation`, `acronym`)".
"VALUES (8,'Flower Scent','','','')";
$connection->query($sql);

$sql = "INSERT INTO `morpheme`(`mid`, `name`, `synonyms`, `abbreviation`, `acronym`)".
"VALUES (9,'Flower Shape','','','')";
$connection->query($sql);

$sql = "INSERT INTO `morpheme`(`mid`, `name`, `synonyms`, `abbreviation`, `acronym`)".
"VALUES (10,'Flower Symmetry','','','')";
$connection->query($sql);

$sql = "INSERT INTO `morpheme`(`mid`, `name`, `synonyms`, `abbreviation`, `acronym`)".
"VALUES (11,'Stamen Length','','','')";
$connection->query($sql);

$sql = "INSERT INTO `morpheme`(`mid`, `name`, `synonyms`, `abbreviation`, `acronym`)".
"VALUES (12,'Petal Number','','','')";
$connection->query($sql);

$sql = "INSERT INTO `morpheme`(`mid`, `name`, `synonyms`, `abbreviation`, `acronym`)".
"VALUES (13,'Stamen Number','','','')";
$connection->query($sql);

$sql = "INSERT INTO `morpheme`(`mid`, `name`, `synonyms`, `abbreviation`, `acronym`)".
"VALUES (14,'Ploidy','','','')";
$connection->query($sql);

echo "Done! Please check the database";

?>

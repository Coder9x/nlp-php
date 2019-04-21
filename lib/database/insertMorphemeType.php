
<?php
require('dbconfig.php');

$sql = "ALTER TABLE `morpheme_type` ADD UNIQUE `unique_index`(`mid`, `tid`)";
$connection->query($sql);

$sql = "INSERT INTO `morpheme_type`(`mid`, `tid`)".
" VALUES ('7','4')";
$connection->query($sql);

$sql = "INSERT INTO `morpheme_type`(`mid`, `tid`)".
" VALUES ('4','2')";
$connection->query($sql);

$sql = "INSERT INTO `morpheme_type`(`mid`, `tid`)".
" VALUES ('4','3')";
$connection->query($sql);

$sql = "INSERT INTO `morpheme_type`(`mid`, `tid`)".
" VALUES ('4','5')";
$connection->query($sql);

$sql = "INSERT INTO `morpheme_type`(`mid`, `tid`)".
" VALUES ('13','2')";
$connection->query($sql);

echo "Done! Please check the database";

?>

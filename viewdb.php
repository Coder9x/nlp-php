<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
th, td {
  padding: 5px;
}
th {
  text-align: left;
}
</style>

<?php
require('lib/database/dbconfig.php');


$sql = "SELECT morpheme.name as 'Morpheme', type.name as 'Type' FROM morpheme_type INNER JOIN morpheme ON morpheme.mid = morpheme_type.mid INNER JOIN type ON type.tid = morpheme_type.tid";
$result = $connection->query($sql);
// morpheme and type
echo "<table>";
echo "  <tr>
          <th>Morpheme</th>
          <th>Type</th>
        </tr>";

if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()){
        echo "<tr>";
          echo "<td>".$row['Morpheme']."</td>";
          echo "<td>".$row['Type']."</td>";
        echo "</tr>";

        }

}
echo "</table>";



?>

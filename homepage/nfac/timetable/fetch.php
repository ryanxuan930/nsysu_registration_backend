<?php
header('Access-Control-Allow-Origin: *');
require("../../../../database.php");
$db = new database("sep3");
$db->table("nfac_schedule");
$result = $db->select_all();
$dataset = array();
$i=0;
while($row = $result->fetch_assoc()){
    $dataset[$i] = $row;
}
$obj = json_encode($dataset);
echo $obj;
?>
<?php
header('Access-Control-Allow-Origin: *');
require("../database.php");
$db = new database("sep3");
$db->table("department");
$result = $db->select_all();
$dataset = array();
$i=0;
while($row = $result->fetch_assoc()){
    $dataset[$i]["id"] = $row["id"];
    $dataset[$i]["dept_ch"] = $row["ch"];
    $dataset[$i]["dept_en"] = $row["en"];
    $i++;
}
$obj = json_encode($dataset);
echo $obj;
?>
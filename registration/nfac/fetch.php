<?php
header('Access-Control-Allow-Origin: *');
require("../../database.php");
$token = $_POST["token"];
$token_data = tokenDecrypt($token);
$dataset = array();
$db = new database("sep3");
$db->table("nfac_main");
$result = $db->select_where("event","stu_id='{$token_data["account"]}'");
if($result->num_rows){
    while($row = $result->fetch_assoc()){
        array_push($dataset, $row["event"]);
    }
}
$obj = json_encode($dataset);
echo $obj;
?>
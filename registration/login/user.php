<?php
header('Access-Control-Allow-Origin: *');
require("../../database.php");
$dataset = array();
$token = $_POST["token"];
$data = tokenDecrypt($token);
$db = new database('sep3');
$db->table("department");
$result = $db->select_where(0,"id='{$data["dept"]}'");
if($result->num_rows){
    while($row = $result->fetch_assoc()){
        $dataset["dept_ch"] = $row["ch"];
        $dataset["dept_en"] = $row["en"];
    }
}
$db=0;
$db = new database("sep3");
$db->table("member");
$result = $db->select_where(0,"stu_id='{$data["account"]}'");
if($result->num_rows){
    while($row = $result->fetch_assoc()){
        $dataset["name"] = $row["name"];
        $dataset["stu_id"] = $row["sdu_id"];
        $dataset["g_year"] = $row["g_year"];
        $dataset["sex_title"] = sex($row["sex"]);
        $dataset["sex"] = $row["sex"];
    }
}
$obj = json_encode($dataset);
echo $obj;
?>
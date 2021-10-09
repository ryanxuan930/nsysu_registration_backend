<?php
header('Access-Control-Allow-Origin: *');
require("../../database.php");
$token = $_POST["token"];
$token_data = tokenDecrypt($token);
if(isset($_POST["sex"]) and ($_POST["sex"]==1 or $_POST["sex"]==2)){
    $sex = $_POST["sex"];
}else{
    echo "sex";
    exit();
}
if(isset($_POST["event"])){
    $event = json_decode($_POST["event"],true);
}else{
    echo "event";
    exit();
}
$conn->select_db("sep3");
$conn->query("DELETE FROM nfac_main WHERE stu_id='{$token_data['account']}'");
$stmt = $conn->prepare("INSERT INTO nfac_main (stu_id, sex, event) VALUES (?,?,?)");
$e = 0;
$stmt->bind_param("sis",$token_data["account"],$sex,$e);
foreach($event as $value){
    $e = $value;
    $stmt->execute();
    if($conn->error){
        echo $conn->error;
    }
}
echo "done";
?>
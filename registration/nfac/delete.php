<?php
header('Access-Control-Allow-Origin: *');
require("../../database.php");
$token = $_POST["token"];
$token_data = tokenDecrypt($token);
$conn->select_db("sep3");
$conn->query("DELETE FROM nfac_main WHERE stu_id='{$token_data['account']}'");
if($conn->error){
    echo $conn->error;
}
echo "done";
?>
<?php
header('Access-Control-Allow-Origin: *');
require("../../database.php");
if(isset($_POST["account"]) and strlen($_POST["account"])==10){
    $account = $_POST["account"];
}else{
    $status = 0;
    goto endpoint;
}
$conn->select_db('sep3');
$stmt = $conn->prepare("SELECT stu_id FROM member WHERE stu_id=?");
$stmt->bind_param("s",$account);
$stmt->execute();
$result = $stmt->get_result();
if($result->num_rows){
    $status=1;
}else{
    $status=0;
}
goto endpoint;
endpoint:
echo $status;
?>
<?php
header('Access-Control-Allow-Origin: *');
require("../../database.php");
$dataset = array();
if(!empty($_SERVER['HTTP_CLIENT_IP'])){
   $ip = $_SERVER['HTTP_CLIENT_IP'];
}else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
   $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
}else{
   $ip= $_SERVER['REMOTE_ADDR'];
}
if(isset($_POST["account"])){
    $account = htmlspecialchars($_POST["account"]);
}else{
    $dataset["status"]="invalid_account";
    goto endpoint;
}
if(isset($_POST["password"])){
    $password = $_POST["password"];
}else{
    $dataset["status"]="invalid_password";
    goto endpoint;
}
$time = time();
$conn->select_db("sep3");
echo $conn->error;
$stmt = $conn->prepare("SELECT * FROM member WHERE stu_id=?");
echo $conn->error;
$stmt->bind_param("s",$account);
$stmt->execute();
$result = $stmt->get_result();
if($result->num_rows){
    while($row = $result->fetch_assoc()){
        $hash = $row["password"];
        if(password_verify($password,$hash)){
            $dataset["status"]="welcome";
            $dataset["token"]=tokenEncrypt($account,$row["dept"],$ip,$time);
            goto endpoint;
        }else{
            $dataset["status"]="wrong_password";
            goto endpoint;
        }
    }
}else{
    $dataset["status"]="account_is_not_found";
    goto endpoint;
}
endpoint:
$obj = json_encode($dataset);
echo $obj;
?>
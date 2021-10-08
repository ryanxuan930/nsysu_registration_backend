<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: Origin, Methods, Content-Type");
require("../../database.php");
if(isset($_POST["dept"]) and strlen($_POST["dept"])==3){
    $org = $_POST["dept"];
}else{
    echo "dept";
    exit();
}
if(isset($_POST["email"]) and filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
    $email = $_POST["email"];
}else{
    echo "email";
    exit();
}
if(isset($_POST["stu_id"]) and strlen($_POST["stu_id"])==10){
    $account = $_POST["stu_id"];
}else{
    echo "account";
    exit();
}
if(isset($_POST["g_year"]) and is_numeric($_POST["g_year"])){
    $g_year = $_POST["g_year"];
}else{
    echo "number";
    exit();
}
if(isset($_POST["name"])){
    $name = htmlspecialchars($_POST["name"]);
}else{
    echo "name";
    exit();
}
if(isset($_POST["sex"]) and ($_POST["sex"]==1 or $_POST["sex"]==2)){
    $sex = $_POST["sex"];
}else{
    echo "sex";
    exit();
}
if(isset($_POST["password"])){
    $password = password_hash($_POST["password"],PASSWORD_DEFAULT);
}else{
    echo "password";
    exit();
}
$conn->select_db('sep3');
$stmt = $conn->prepare("INSERT INTO member (stu_id, name, dept, g_year, sex, email, password) VALUES (?,?,?,?,?,?,?)");
$stmt->bind_param("sssiiss",$stu_id,$name,$dept,$g_year,$sex,$email,$password);
$stmt->execute();
if($stmt->error){
    echo $stmt->error;
}else{
    echo "done";
}

?>
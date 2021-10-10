<?php
header('Access-Control-Allow-Origin: *');
require("../../database.php");
if(isset($_POST["dept"])){
    $dept = $_POST["dept"];
}else{
    echo "invalid_dept";
    exit();
}
if(isset($_POST["email"]) and filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
    $email = $_POST["email"];
}else{
    echo "invalid_email";
    exit();
}
if(isset($_POST["stu_id"]) and strlen($_POST["stu_id"])==10){
    $stu_id= $_POST["stu_id"];
}else{
    echo "invalid_stu_id";
    exit();
}
if(isset($_POST["g_year"]) and is_numeric($_POST["g_year"])){
    $g_year = $_POST["g_year"];
}else{
    echo "invalid_g_year";
    exit();
}
if(isset($_POST["name"])){
    $name = htmlspecialchars($_POST["name"]);
}else{
    echo "invalid_name";
    exit();
}
if(isset($_POST["sex"]) and ($_POST["sex"]==1 or $_POST["sex"]==2)){
    $sex = $_POST["sex"];
}else{
    echo "invalid_sex";
    exit();
}
if(isset($_POST["password"])){
    $password = password_hash($_POST["password"],PASSWORD_DEFAULT);
}else{
    echo "invalid_password";
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
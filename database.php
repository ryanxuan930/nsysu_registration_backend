<?php
class database extends mysqli{
	private $server="127.0.0.1";
	private $username="rikujo";
	private $password="Rikujo0911352265";
	private $db=0;
	private $table=0;
	public $conn=0;
	function __construct($db){
    	$this->db = $db;
		$this->conn = mysqli_connect($this->server, $this->username, $this->password, $db);
		mysqli_query($this->conn, 'set names utf8');
  	}
	public function db($db_name){
		$this->db = $db_name;
		mysqli_select_db($this->conn, $db_name);
	}
	public function table($tb_name){
		$this->table = $tb_name;
	}
	public function clone_table($tb_name1, $tb_name2){
		$sql = "CREATE TABLE ".$tb_name1." LIKE ".$tb_name2."";
		return mysqli_query($this->conn, $sql);
	}
	public function select_all(){
		$sql = "SELECT * FROM ".$this->table."";
		return mysqli_query($this->conn, $sql);
	}
    public function select_all_order($order){
		$sql = "SELECT * FROM ".$this->table." ORDER BY ".$order."";
		return mysqli_query($this->conn, $sql);
	}
	public function select_order($select,$order){
        if($select === 0){
            $select = '*';
        }
		$sql = "SELECT ".$select." FROM ".$this->table." ORDER BY ".$order."";
		return mysqli_query($this->conn, $sql);
	}
	public function select($select){
		$sql = "SELECT ".$select." FROM ".$this->table."";
		return mysqli_query($this->conn, $sql);
	}
	public function select_where($select, $where){
        if($select === 0){
            $select = '*';
        }
		$sql = "SELECT ".$select." FROM ".$this->table." WHERE ".$where." ";
        return mysqli_query($this->conn, $sql);
	}
	public function select_where_order($select, $where, $order){
        if($select === 0){
            $select = '*';
        }
		$sql = "SELECT ".$select." FROM ".$this->table." WHERE ".$where." ORDER BY ".$order."";
        return mysqli_query($this->conn, $sql);
	}
	public function distinct_where_order($select, $where, $order){
		$sql = "SELECT DISTINCT ".$select." FROM ".$this->table." WHERE ".$where." ORDER BY ".$order."";
        return mysqli_query($this->conn, $sql);
	}
	public function insert($columns, $values){
		$sql = "INSERT INTO ".$this->table." (".$columns.") VALUES (".$values.")";
		return mysqli_query($this->conn, $sql);
	}
	public function update($set, $where){
		$sql = "UPDATE ".$this->table." SET ".$set." WHERE ".$where."";
		return mysqli_query($this->conn, $sql);
	}
	public function delete($where){
		$sql = "DELETE FROM ".$this->table." WHERE ".$where."";
		return mysqli_query($this->conn, $sql);
	}
	public function clear(){
		$sql = "DELETE FROM ".$this->table."";
		return mysqli_query($this->conn, $sql);
	}
	public function seq_reset(){
		$sql = "ALTER TABLE ".$this->table." AUTO_INCREMENT = 1";
		return mysqli_query($this->conn, $sql);
	}
	public function exist(){
		$sql = "SELECT * FROM ".$this->table."";
		$result = mysqli_query($this->conn, $sql);
		if($result){
			return 1;
		}else{
			return 0;
		}
	}
	public function error(){
		echo mysqli_error($this->conn);
	}
	public function status(){
		echo 'server: '.$this->server.'<br>';
		echo 'username: '.$this->username.'<br>';
		echo 'password: '.$this->password.'<br>';
		echo 'database: '.$this->db.'<br>';
		echo 'table: '.$this->table.'<br>';
	}
}

$dbserver="127.0.0.1";
$dbusername="rikujo";
$dbpassword="Rikujo0911352265";
$conn = new mysqli($dbserver, $dbusername, $dbpassword);
if ($conn->connect_error) {
    die("連線失敗：" . $conn->connect_error);
}
$conn->query("SET names utf8mb4");
date_default_timezone_set('Asia/Taipei');
$error_mode = 1;
$SYSTEM_PATH=$_SERVER['DOCUMENT_ROOT']."/rikujo/education/root/";
function number($num){
    if($num<10){
        $num = '0'.$num;
    }
    return $num;
}
function sex($sex){
    if($sex==1){
        return '男';
    }else{
        return '女';
    }
}
function tokenEncrypt($account,$dept,$ip,$ini_time){
    $key = 'T$w2?z#_P6@*nR!li5q%';
    $dataset = array();
    $dataset["account"] = $account;
    $dataset["dept"] = $dept;
    $dataset["ip"] = $ip;
    $dataset["ini_time"] = $ini_time;
    $dataset["exp_time"] = $ini_time+86400;
    $data = json_encode($dataset);
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
    return base64_encode($encrypted . '::' . $iv);
}
function tokenDecrypt($ciphertext){
    $key = 'T$w2?z#_P6@*nR!li5q%';
    list($encrypted_data, $iv) = explode('::', base64_decode($ciphertext), 2);
    $decrypt = openssl_decrypt($encrypted_data, 'aes-256-cbc', $key, 0, $iv);
	if(json_decode($decrypt, true)){
		$data = json_decode($decrypt, true);
	}else{
		$dataset["account"] = 0;
    	$dataset["dept"] = "0";
    	$dataset["ip"] = 0;
    	$dataset["ini_time"] = 0;
    	$dataset["exp_time"] = 0;
    	$data = $dataset;
	}
    
    return $data;
}

function categoryName($category){
    switch($category){
        case 0:
            return "檔案下載";
            break;
        case 1:
            return "一般公告";
            break;
        case 2:
            return "賽事資訊";
            break;
        case 3:
            return "置頂消息";
            break;
    }
}
?>
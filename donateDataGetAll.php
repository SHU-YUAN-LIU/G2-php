<?php 
$donateData = json_decode(file_get_contents("php://input"), true);

try {
    
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
	if($_SERVER["HTTP_HOST"]=='localhost' || $_SERVER["HTTP_HOST"] == '127.0.0.1'){
        require_once("connect_local.php");
    }else{
        // require_once("https://tibamef2e.com/chd104/g2/php/connect_chd104g2.php");
        require_once("connect_chd104g2.php");

    }
	//建立sql指令
    // $sql = "select * from donate_record";改之前
    $sql = "SELECT * FROM `donate_record` a LEFT JOIN `member` b ON a.member_no = b.member_no;";
    $donates = $pdo->query($sql);
	$donateRows = $donates->fetchAll(PDO::FETCH_ASSOC);

	$result = ["error" => false, "msg" => "", "donates" => $donateRows];

} catch (PDOException $e) {
	$result = ["error" => true, "msg" => $e->getMessage()];
	// echo "系統暫時不能正常運行，請稍後再試<br>";	
}
echo json_encode($result);
?>
<?php 
$memberData = json_decode(file_get_contents("php://input"), true);
ini_set("display_errors","On");
try {
    
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
	if($_SERVER["HTTP_HOST"]=='localhost' || $_SERVER["HTTP_HOST"] == '127.0.0.1'){
        require_once("connect_local.php");
    }else{
        require_once("https://tibamef2e.com/chd104/g2/php/connect_chd104g2");
    }
	//建立sql指令
    $sql = "select * from member";
    $members = $pdo->query($sql);
	$memberRows = $members->fetchAll(PDO::FETCH_ASSOC);

	$result = ["error" => false, "msg" => "", "members" => $memberRows];

} catch (PDOException $e) {
	$result = ["error" => true, "msg" => $e->getMessage()];
	// echo "系統暫時不能正常運行，請稍後再試<br>";	
}
echo json_encode($result);
?>
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
        require_once("https://tibamef2e.com/chd104/g2/php/connect_chd104g2.php");
    }
	//建立sql指令
    $sql = "update member set status=:member_status, modify_date=now() where member_no=:member_no";

    $member = $pdo->prepare($sql);
    $member->bindValue(":member_no", $memberData["member_no"]);
    $member->bindValue(":member_status", $memberData["status"]);
    $member->execute();

	$result = ["error" => false, "msg" => "成功修改會員資料"];

} catch (PDOException $e) {
	$result = ["error" => true, "msg" => $e->getMessage()];
	// echo "系統暫時不能正常運行，請稍後再試<br>";	
}
echo json_encode($result);
?>
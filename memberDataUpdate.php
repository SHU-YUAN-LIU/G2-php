<?php 
$memberData = json_decode(file_get_contents("php://input"), true);

try {
    
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
	require_once("connect_chd104g2.php");
	//建立sql指令
    $sql = "update member set member_name=:member_name";
    $member = $pdo->prepare($sql);
    $member->bindValue(":member_name", $memberData["member_name"]);
    $member->execute();

	$result = ["error" => false, "msg" => "成功修改會員資料"];

} catch (PDOException $e) {
	$result = ["error" => true, "msg" => $e->getMessage()];
	// echo "系統暫時不能正常運行，請稍後再試<br>";	
}
echo json_encode($result);
?>
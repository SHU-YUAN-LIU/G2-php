<?php 
$adminData = json_decode(file_get_contents("php://input"), true);

try {
    
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
	require_once("connect_chd104g2.php");
	//建立sql指令
    $sql = "select * from admin_master";
    $admins = $pdo->query($sql);
	$adminRows = $admins->fetchAll(PDO::FETCH_ASSOC);

	$result = ["error" => false, "msg" => "", "admins" => $adminRows];

} catch (PDOException $e) {
	$result = ["error" => true, "msg" => $e->getMessage()];
	// echo "系統暫時不能正常運行，請稍後再試<br>";	
}
echo json_encode($result);
?>
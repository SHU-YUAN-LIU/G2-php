<?php
$adminData = json_decode(file_get_contents("php://input"), true);

try {

	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
	require_once("connect_chd104g2.php");
	//建立sql指令
	$sql = "select 
	a.admin_no as 'admin_no',
	a.admin_name as 'admin_name',
	a.admin_psw as 'admin_psw',
	a.status as 'status',
	a.admin_level as 'admin_level',
	a.creator as 'creator',
	a.admin_hiredate as 'admin_hiredate',
	a.modifier as 'modifier',
	a.modify_date as 'modify_date',
	b.admin_name as 'modifier_name'
	from admin_master a join admin_master b on a.modifier = b.admin_no;";
	$admins = $pdo->query($sql);
	$adminRows = $admins->fetchAll(PDO::FETCH_ASSOC);

	$result = ["error" => false, "msg" => "", "admins" => $adminRows];

} catch (PDOException $e) {
	$result = ["error" => true, "msg" => $e->getMessage()];
	// echo "系統暫時不能正常運行，請稍後再試<br>";	
}
echo json_encode($result);
?>
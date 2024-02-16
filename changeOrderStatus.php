<?php 
$order_no=$_POST['order_no'];
$status=$_POST['status'];
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
    $sql = "update orders set status=:order_status where orders_no=:order_no";

    $order = $pdo->prepare($sql);
    $order->bindValue(":order_status", $status);
    $order->bindValue(":order_no", $order_no);
    $order->execute();

	$result = ["error" => false, "msg" => "成功修改訂單資料"];

} catch (PDOException $e) {
	$result = ["error" => true, "msg" => $e->getMessage()];
	// echo "系統暫時不能正常運行，請稍後再試<br>";	
}
echo json_encode($result);
?>
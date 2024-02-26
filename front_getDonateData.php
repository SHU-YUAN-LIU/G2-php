<?php
$donate_no = json_decode(file_get_contents("php://input"), true);
try {

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    // require_once("connect_chd104g2.php");

    if ($_SERVER["HTTP_HOST"] == 'localhost' || $_SERVER["HTTP_HOST"] == '127.0.0.1') {
        require_once("connect_local.php");
    } else {
        // require_once("https://tibamef2e.com/chd104/g2/php/connect_chd104g2.php");
        require_once("connect_chd104g2.php");
    }

    //建立sql指令
    $sql = "select 
    donate_no,
    donate_date,
    donate_method,
    donate_amount,
    point
	from donate_record
    where member_no=:member_no;";
    $donate = $pdo->prepare($sql);
    $donate->bindValue(':member_no', $donate_no['member_no']);
    $donate->execute();
    $donateRows = $donate->fetchAll(PDO::FETCH_ASSOC);

    //檢查是否成功獲得數據
    if ($donateRows) {
        $result = ["error" => false, "msg" => "", "donate" => $donateRows];
    } else {
        $result = ["error" => true, "msg" => "未找到對應的商品訂單"];
    }
} catch (PDOException $e) {
    $result = ["error" => true, "msg" => $e->getMessage()];
    // echo "系統暫時不能正常運行，請稍後再試<br>";	
}
echo json_encode($result);

<?php
$adminData = json_decode(file_get_contents("php://input"), true);

//用來將錯誤訊息直接輸出到瀏覽器
ini_set("display_errors", "On");

try {
    //許可所有來源允許訪問伺服器的資源
    header("Access-Control-Allow-Origin: *");
    //訪問方式允許進行跨域請求
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    //這個標頭指定了哪些 HTTP 標頭可以在實際的請求中使用
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    // require_once("connect_chd104g2.php");

    if ($_SERVER["HTTP_HOST"] == 'localhost' || $_SERVER["HTTP_HOST"] == '127.0.0.1') {
        require_once("connect_local.php");
    } else {
        // require_once("https://tibamef2e.com/chd104/g2/php/connect_chd104g2");
        require_once("connect_chd104g2.php");

    }

    if (
            //檢查欄位是否存在 且 欄位是否有值
        (!isset($adminData["admin_name"]) || empty($adminData["admin_name"])) ||
        (!isset($adminData["admin_psw"]) || empty($adminData["admin_psw"])) ||
        (!isset($adminData["status"]) || empty($adminData["status"])) ||
        (!isset($adminData["admin_level"]) || !is_numeric($adminData["admin_level"]))
    ) {
        $result = ["error" => true, "msg" => "請提供所有必填欄位的值"];
    } else {

        //建立sql指令
        $sql = "insert into admin_master 
    (admin_name,admin_psw,status,admin_level,creator,admin_hiredate,modifier,modify_date)
    values (:admin_name,:admin_psw,:status,:admin_level,:creator,now(),:modifier,now())";

        $admins = $pdo->prepare($sql);
        $admins->bindValue(":admin_name", $adminData["admin_name"]);
        $admins->bindValue(":admin_psw", $adminData["admin_psw"]);
        $admins->bindValue(":status", $adminData["status"]);
        $admins->bindValue(":admin_level", $adminData["admin_level"]);
        $admins->bindValue(":creator", $adminData["creator"]);
        $admins->bindValue(":modifier", $adminData["modifier"]);
        $admins->execute();

        $result = ["error" => false, "msg" => "成功新增管理員資料"];
    }

} catch (PDOException $e) {
    $result = ["error" => true, "msg" => $e->getMessage()];
    // echo "系統暫時不能正常運行，請稍後再試<br>";	
}
echo json_encode($result);
?>
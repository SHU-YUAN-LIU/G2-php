<?php
// print_r($_POST); // 臨時加這行來檢查接收到的數據
$email = $_POST['email'];
$psw = $_POST['psw'];
ini_set("display_errors", "On");
try {

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    if ($_SERVER["HTTP_HOST"] == 'localhost' || $_SERVER["HTTP_HOST"] == '127.0.0.1') {
        require_once("connect_local.php");
    }else{
        // require_once("https://tibamef2e.com/chd104/g2/php/connect_chd104g2.php");
        require_once("connect_chd104g2.php");
    }
    //建立sql指令
    $sql = "select * from member where email=:member_email and password=:member_psw";
    $member = $pdo->prepare($sql);
    $member->bindValue(":member_email",$email);
    $member->bindValue(":member_psw",$psw);
    $member->execute();
    $memberRow = $member->fetchAll(PDO::FETCH_ASSOC);

    if (count($memberRow) > 0) {
        // 用戶存在，處理登入成功的邏輯
        $result = ["error" => false, "code" => 1, "member" => $memberRow];
    } else {
        // 用戶不存在或密碼錯誤，處理登入失敗的邏輯
        $result = ["error" => true, "code" => 0, "msg" => "登入失敗，電子郵件或密碼錯誤。"];
    }
    
} catch (PDOException $e) {
    $result = ["error" => true, "msg" => $e->getMessage()];
    // echo "系統暫時不能正常運行，請稍後再試<br>";	
}
echo json_encode($result);

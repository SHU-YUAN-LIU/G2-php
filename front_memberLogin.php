<?php
// print_r($_POST); // 臨時加這行來檢查接收到的數據
$email = $_POST['email'];
$psw = $_POST['psw'];
ini_set("display_errors", "On");
session_start();
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
    $memberRow = $member->fetch(PDO::FETCH_ASSOC);


    if (count($memberRow) > 0) {
        // 用戶存在，處理登入成功的邏輯
        unset($memberRow['password']); // 從結果中移除密碼
        $_SESSION['user'] = $memberRow; // 存儲用戶資料到 session
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




// // 使用 password_hash 轉換哈希密碼
// $storedPswHash = password_hash($psw, PASSWORD_DEFAULT); //$psw註冊時輸入之密碼
// // 更新資料庫中的密碼欄位
// $updateSql = "UPDATE member SET password='$storedPswHash' WHERE member_no='$member_no'";


//哈希值寫法
    // if (count($memberRow) > 0) {
    //     $storedPswHash = $memberRow[0]['password'];
    //     //使用 password_verify() 函數檢查用戶輸入的密碼是否與存儲的哈希值匹配
    //     if (password_verify($psw, $storedPswHash)) {
    //         //移除儲存密碼
    //         unset($memberRow[0]['password']); 
    //         // 將用戶數據存儲到session中，以便於後續請求中使用
    //         $_SESSION['user'] = $memberRow[0];
    //         $result = ["error" => false, "code" => 1, "member" => $memberRow[0]];
    //     } else {
    //         $result = ["error" => true, "code" => 0, "msg" => "登入失敗，電子郵件或密碼錯誤。"];
    //     }

    // } else {
    //     $result = ["error" => true, "code" => 0, "msg" => "登入失敗，電子郵件或密碼錯誤。"];
    // }
    
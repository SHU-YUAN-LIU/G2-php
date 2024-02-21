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
    echo "系統暫時不能正常運行，請稍後再試<br>";	
}
echo json_encode($result);























// $memberData = json_decode(file_get_contents("php://input"), true);
// ini_set("display_errors","On");

// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
// header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// if($_SERVER["HTTP_HOST"]=='localhost' || $_SERVER["HTTP_HOST"] == '127.0.0.1'){
//     require_once("connect_local.php");
// }else{
//     require_once("connect_chd104g2.php");
// }

// try {
//     // 生成新的哈希密码
//     $Password = "8787"; // 这应该是从某处获取的新密码，例如表单输入
//     $hashedPassword = password_hash($Password, PASSWORD_DEFAULT);

//     // 更新数据库记录
//     $sql = "UPDATE member SET password=:hashedPassword WHERE email='8787@gmail.com' AND password='8787'";
//     // 注意：直接在SQL中使用明文密码（'8787'）通常不是一个好做法，这里仅为示例。
//     // 实际应用中，应避免在WHERE子句中检查明文密码。

//     $stmt = $pdo->prepare($sql);
//     $stmt->bindValue(":hashedPassword", $hashedPassword);
//     $stmt->execute();

//     if ($stmt->rowCount() > 0) {
//         $result = ["error" => false, "msg" => "成功修改密码"];
//     } else {
//         $result = ["error" => true, "msg" => "未找到匹配的记录或密码未变更"];
//     }
// } catch (PDOException $e) {
//     $result = ["error" => true, "msg" => $e->getMessage()];
// }

// echo json_encode($result);
?>

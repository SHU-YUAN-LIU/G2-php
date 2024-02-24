<?php

ini_set("display_errors", "On");

try {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    if ($_SERVER["HTTP_HOST"] == 'localhost' || $_SERVER["HTTP_HOST"] == '127.0.0.1') {
        require_once("connect_local.php");
    } else {
        require_once("connect_chd104g2.php");
    }

    // 從POST請求正文讀取數據
    $postData = json_decode(file_get_contents("php://input"), true);
    $email = $postData['email'] ?? null; // 安全地檢查並分配email變量

    if (!$email) {
        throw new Exception("沒有提供郵件地址");
    }

    $sql = "SELECT * FROM member WHERE email = :member_email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":member_email", $email);
    $stmt->execute();
    $memberRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($memberRows) {
        $result = ["error" => false, "msg" => "", "member" => $memberRows];
    } else {
        $result = ["error" => true, "msg" => "未找到會員資料"];
    }
} catch (PDOException $e) {
    $result = ["error" => true, "msg" => $e->getMessage()];
}

echo json_encode($result);
?>






































//     if (isset($_SESSION['member'])) {
//         // 假設登入時，已將會員資訊存在 $_SESSION['member'] 中
//         $memberData = $_SESSION['member']; // 直接從 session 中獲取會員資訊

//         $result = ["error" => false, "msg" => "", "member" => $memberData];
//     } else {
//         // 如果 session 中沒有會員資訊
//         $result = ["error" => true, "msg" => "請登入會員"];
//     }
// } catch (Exception $e) {
//     $result = ["error" => true, "msg" => $e->getMessage()];
// }

// echo json_encode($result); // 將結果以 JSON 格式返回






?>
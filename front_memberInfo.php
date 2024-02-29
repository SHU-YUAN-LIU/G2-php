<?php
// ini_set("display_errors", "On");

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
    // $email = $postData['email'] ?? null; // 安全地檢查並分配email變量

    // if (!$email) {
    //     throw new Exception("沒有提供郵件地址");
    // }

    $sql = "select * from member where email = :member_email";
    $members = $pdo->prepare($sql);
    $members->bindValue(":member_email", $postData["email"]);
    // $stmt->bindValue(":member_email", $email);
    $members->execute();
    $memberRow = $members->fetchAll(PDO::FETCH_ASSOC);

    $result = ["error" => false, "member" => $memberRow];
} catch (PDOException $e) {
    $result = ["error" => true, "msg" => $e->getMessage()];
}

echo json_encode($result);

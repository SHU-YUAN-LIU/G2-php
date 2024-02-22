<?php
ini_set("display_errors", "On");
session_start();

try {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    if (isset($_SESSION['member'])) {
        // 假設登入時，已將會員資訊存在 $_SESSION['member'] 中
        $memberData = $_SESSION['member']; // 直接從 session 中獲取會員資訊

        $result = ["error" => false, "msg" => "", "member" => $memberData];
    } else {
        // 如果 session 中沒有會員資訊
        $result = ["error" => true, "msg" => "請登入會員"];
    }
} catch (Exception $e) {
    $result = ["error" => true, "msg" => $e->getMessage()];
}

echo json_encode($result); // 將結果以 JSON 格式返回






?>
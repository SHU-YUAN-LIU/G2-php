<?php
$email = $_POST['email'];
$psw = $_POST['psw'];

ini_set("display_errors", "On");

try {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    if ($_SERVER["HTTP_HOST"] == 'localhost' || $_SERVER["HTTP_HOST"] == '127.0.0.1') {
        require_once("connect_local.php");
    } else {
        require_once("https://tibamef2e.com/chd104/g2/php/connect_chd104g2.php"); // 更改為正確的本地路徑
    }

    $sql = "SELECT * FROM member WHERE email = :member_email AND password = :member_psw";
    $member = $pdo->prepare($sql);
    $member->bindValue(":member_email", $email);
    $member->bindValue(":member_psw", $psw);
    $member->execute();
    $memberRow = $member->fetchAll(PDO::FETCH_ASSOC);

    $result = ["error" => false, "member" => $memberRow];
} catch (PDOException $e) {
    $result = ["error" => true, "msg" => $e->getMessage()];
}

echo json_encode($result);
?>

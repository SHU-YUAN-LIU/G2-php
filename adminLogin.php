<?php
$account = $_POST['account'];
$psw = $_POST['psw'];
ini_set("display_errors", "On");
try {

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    if ($_SERVER["HTTP_HOST"] == 'localhost' || $_SERVER["HTTP_HOST"] == '127.0.0.1') {
        require_once("connect_local.php");
    }else{
        require_once("https://tibamef2e.com/chd104/g2/php/connect_chd104g2.php");
    }
    //建立sql指令
    $sql = "select * from admin_master where admin_no=:admin_no and admin_psw=:admin_psw";
    $admin = $pdo->prepare($sql);
    $admin->bindValue(":admin_no",$account);
    $admin->bindValue(":admin_psw",$psw);
    $admin->execute();
    $adminRow = $admin->fetchAll(PDO::FETCH_ASSOC);


    $result = ["error" => false, "admin" => $adminRow];
} catch (PDOException $e) {
    $result = ["error" => true, "msg" => $e->getMessage()];
    // echo "系統暫時不能正常運行，請稍後再試<br>";	
}
echo json_encode($result);

<?php
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

<?php
$registerForm = json_decode(file_get_contents("php://input"), true);
//true一定要寫,json_decode()把字串變物件(PHP的方法)
echo $registerForm ;

//用來將錯誤訊息直接輸出到瀏覽器
ini_set("display_errors", "On");

try {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    // require_once("connect_chd104g2.php");

    if ($_SERVER["HTTP_HOST"] == 'localhost' || $_SERVER["HTTP_HOST"] == '127.0.0.1') {
        require_once("connect_local.php");
    } else {
        // require_once("https://tibamef2e.com/chd104/g2/php/connect_chd104g2");
        require_once("connect_chd104g2.php");
    }

        //建立sql指令
        $sql = " insert into member
        (member_name,cellphone,email,password,status,create_date,birthday,id_number)
        values 
        (:member_name,:cellphone,:email,:password,:status,now(),:birthday,:id_number)";

        $memberData = $pdo->prepare($sql); //php語法(先執行一次,可以提升安全,做完這句指令,讓他限縮在挖空的裡面)
        $memberData->bindValue(":member_name", $registerForm["member_name"]);
        $memberData->bindValue(":cellphone", $registerForm["cellphone"]);
        $memberData->bindValue(":email", $registerForm["email"]);
        $memberData->bindValue(":password", $registerForm["password"]);
        $memberData->bindValue(":status", 'A');
        $memberData->bindValue(":birthday", $registerForm["birthday"]);
        $memberData->bindValue(":id_number", $registerForm["id_number"]);
        $memberData->execute();

        if (!isset($registerForm["member_name"], $registerForm["cellphone"], $registerForm["email"], $registerForm["password"], $registerForm["birthday"], $registerForm["id_number"])) {
            throw new Exception("表单字段缺失或格式错误。");
        } 

        $PK = $pdo->lastInsertId(); //拿到上一筆新增的PK(member_no)
        echo json_encode(["PK" => $PK]); // 正確地返回JSON格式的PK
        $result = ["error" => false, "msg" => "註冊成功", "PK" => $PK, "memberData" => $memberData]; //這邊要回傳>新增的PK(member_no)      

} catch (PDOException $e) {
    $result = ["error" => true, "msg" => $e->getMessage()];
    // echo "系統暫時不能正常運行，請稍後再試<br>";	
}
echo json_encode($result);


//小筆記:insert(新增新的資料),update(舊有的資料要更新)
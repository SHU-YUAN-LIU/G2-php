<?php

$memberName = $_POST['member_name'];
$memberBirthday = $_POST['member_birthday'];
$memberEmail = $_POST['member_email'];
$memberCell = $_POST['member_cellphone'];
$memberId = $_POST['member_id'];
$memberPsw = $_POST['member_psw'];

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


    // 檢查信箱是否已存在
    $sql = "SELECT email FROM member WHERE email = :email";
    $checkEmail = $pdo->prepare($sql);
    $checkEmail->bindValue(':email',$memberEmail);
    $checkEmail->execute();
    $checkEmailRows = $checkEmail->fetchAll(PDO::FETCH_ASSOC);

    if (count($checkEmailRows) > 0) {
        $result = ["error" => true, "msg" => "信箱已註冊過"];
    }else{
                //建立sql指令
                $sql = " INSERT INTO member (
                    member_name,
                    cellphone,
                    email,
                    password,
                    status,
                    create_date,
                    birthday,
                    id_number,
                    point,
                    modifier,
                    modify_date
                )
                values 
                (:member_name,:cellphone,:email,:password,:status,now(),:birthday,:id_number, :point, :modifier, now())";
        
                $memberData = $pdo->prepare($sql); //php語法(先執行一次,可以提升安全,做完這句指令,讓他限縮在挖空的裡面)
                $memberData->bindValue(":member_name", $memberName);
                $memberData->bindValue(":cellphone", $memberCell);
                $memberData->bindValue(":email", $memberEmail);
                $memberData->bindValue(":password", $memberPsw);
                $memberData->bindValue(":status", 'A');
                $memberData->bindValue(":birthday", $memberBirthday);
                $memberData->bindValue(":id_number", $memberId);
                $memberData->bindValue(":point", '0');
                $memberData->bindValue(":modifier", '2');
                $memberData->execute();

                $result = ["error" => false, "msg" => "註冊成功"];
    }
} catch (PDOException $e) {
    $result = ["error" => true, "msg" => $e->getMessage()];
    // echo "系統暫時不能正常運行，請稍後再試<br>";	
}
echo json_encode($result);


//小筆記:insert(新增新的資料),update(舊有的資料要更新)
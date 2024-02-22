<?php
$productOrderData = json_decode(file_get_contents("php://input"), true);
//true一定要寫,json_decode()把字串變物件(PHP的方法)

//用來將錯誤訊息直接輸出到瀏覽器
ini_set("display_errors", "On");

try {
    //許可所有來源允許訪問伺服器的資源
    header("Access-Control-Allow-Origin: *");
    //訪問方式允許進行跨域請求
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    //這個標頭指定了哪些 HTTP 標頭可以在實際的請求中使用
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    // require_once("connect_chd104g2.php");

    if ($_SERVER["HTTP_HOST"] == 'localhost' || $_SERVER["HTTP_HOST"] == '127.0.0.1') {
        require_once("connect_local.php");
    } else {
        // require_once("https://tibamef2e.com/chd104/g2/php/connect_chd104g2");
        require_once("connect_chd104g2.php");
    }

    if (

        //檢查欄位是否存在 且 欄位是否有值
        // 檢查 $productOrderData["member_no"] 是否不存在或為空。
        // (!isset($productOrderData["member_no"]) || empty($productOrderData["member_no"])) ||
        (!isset($productOrderData["receiver_name"]) || empty($productOrderData["receiver_name"])) ||
        (!isset($productOrderData["receiver_phone"]) ||  !is_numeric($productOrderData["receiver_phone"])) ||
        (!isset($productOrderData["shipping"]) || empty($productOrderData["shipping"])) ||
        (!isset($productOrderData["receiver_address"]) || empty($productOrderData["receiver_address"])) ||
        (!isset($productOrderData["payment_method"]) || empty($productOrderData["payment_method"])) ||
        // (!isset($productOrderData["total_point"]) || empty($productOrderData["total_point"])) ||
        (!isset($productOrderData["final_price"]) || empty($productOrderData["final_price"]))

    ) {
        $result = ["error" => true, "msg" => "資料尚未填寫完畢"];
    } else {

        //建立sql指令
        $sql = " insert into orders
    (member_no,receiver_name,receiver_phone,shipping,receiver_address,payment_method,status,orders_date,total_point,final_price)
    values 
    (:member_no,:receiver_name,:receiver_phone,:shipping,:receiver_address,:payment_method,:status,now(),:total_point,:final_price)";

        $orders = $pdo->prepare($sql); //php語法(先執行一次,可以提升安全,做完這句指令,讓他限縮在挖空的裡面)
        $orders->bindValue(":member_no", '1'); //先寫死,等會員有再換掉
        $orders->bindValue(":receiver_name", $productOrderData["receiver_name"]);
        $orders->bindValue(":receiver_phone", $productOrderData["receiver_phone"]);
        $orders->bindValue(":shipping", $productOrderData["shipping"]);
        $orders->bindValue(":receiver_address", $productOrderData["receiver_address"]);
        $orders->bindValue(":payment_method", $productOrderData["payment_method"]);
        $orders->bindValue(":status", '處理中');
        $orders->bindValue(":total_point", '300'); //先寫死,等會員有再換掉
        $orders->bindValue(":final_price", $productOrderData["final_price"]);
        $orders->execute();

        $result = ["error" => false, "msg" => "成功新增商品訂單"];
    }
} catch (PDOException $e) {
    $result = ["error" => true, "msg" => $e->getMessage()];
    // echo "系統暫時不能正常運行，請稍後再試<br>";	
}
echo json_encode($result);


//小筆記:insert(新增新的資料),update(舊有的資料要更新)
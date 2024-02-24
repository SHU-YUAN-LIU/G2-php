<?php
$OrderItemData = json_decode(file_get_contents("php://input"), true);
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

    //因為傳過來的cartlist是整包,有些是不需要的,所以用foreach自己找需要的!
    foreach ($OrderItemData as $item) {
        //建立sql指令
        $sql = "INSERT INTO order_item (product_no, qty, price, orders_no) VALUES (:product_no, :qty, :price, :orders_no)";

        $orderItem = $pdo->prepare($sql); //php語法(先執行一次,可以提升安全,做完這句指令,讓他限縮在挖空的裡面)

        $orderItem->bindValue(":product_no", $item["product_no"]);
        $orderItem->bindValue(":qty", $item["qty"]);
        $orderItem->bindValue(":price", $item["price"]);
        $orderItem->bindValue(":orders_no", $item["orders_no"]);

        $orderItem->execute();
    }


    $result = ["error" => false, "msg" => "成功新增商品訂單"];
} catch (PDOException $e) {
    $result = ["error" => true, "msg" => $e->getMessage()];
    // echo "系統暫時不能正常運行，請稍後再試<br>";	
}
echo json_encode($result);


//小筆記:insert(新增新的資料),update(舊有的資料要更新)
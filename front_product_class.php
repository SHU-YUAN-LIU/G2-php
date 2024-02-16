<?php
$productClass = json_decode(file_get_contents("php://input"), true);
//true一定要寫
// json_decode()把字串變物件(PHP的方法)

ini_set("display_errors", "On"); //直接在頁面上看到 PHP 錯誤訊息

try {

    header("Access-Control-Allow-Origin: *"); //允許跨域存取
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    if ($_SERVER["HTTP_HOST"] == 'localhost' || $_SERVER["HTTP_HOST"] == '127.0.0.1') {
        require_once("connect_local.php");
    } else {
        //生產環境
        require_once("https://tibamef2e.com/chd104/g2/php/connect_chd104g2");
    }


    //建立sql指令
    $pdo->beginTransaction(); //sql語法(開始交易)
    $sql = "select * from product_class";
    $productClass = $pdo->prepare($sql); //php語法(再執行一次,可以提升安全)
    $productClass->execute(); // 執行 SQL 語句以獲取資料
    $productClassRows = $productClass->fetchAll(PDO::FETCH_ASSOC); // 檢索資料
    $pdo->commit(); //提交事務

    $result = ["error" => false, "msg" => "", "productClass" => $productClassRows];
} catch (PDOException $e) {
    $pdo->rollBack(); //sql語法(取消新增)
    $result = ["error" => true, "msg" => $e->getMessage()];
    //$e->getMessage()  $e代表一個事件(error事件)->操作 getMessage():這是一個php error方法抓錯誤訊息
}
echo json_encode($result);
// json_encode()把物件變字串(PHP的方法)


//-------------------------------------------------------------------------
// php除錯!!!!!!!!!!!!(看有沒有呼叫到)
// F12->network->fetchXHR
// 假如有php但畫面是空白
// 可能就是回傳的東西有問題php echo有問題
//或是respones或是到處console.log看每個物件長怎樣
// 假如都依樣,可能根本就抓錯資料
//undifine 90%打錯字,不然就是格式跟你要的不一樣

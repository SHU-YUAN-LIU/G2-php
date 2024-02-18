<?php
ini_set("display_errors", "On");
$order_no=$_POST["order_no"];
try {

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    if($_SERVER["HTTP_HOST"]=='localhost' || $_SERVER["HTTP_HOST"] == '127.0.0.1'){
        require_once("connect_local.php");
    }else{
        // require_once("https://tibamef2e.com/chd104/g2/php/connect_chd104g2.php");
        require_once("connect_chd104g2.php");

    }
    //建立sql指令
    $sql = "select a.orders_no,
            c.member_name,
            a.member_no,
            a.receiver_name,
            a.receiver_phone,
            a.payment_method,
            a.receiver_address,
            a.shipping,
            a.orders_no,
            a.orders_date,
            b.product_no,
            d.product_name,
            b.qty,
            b.price,
            a.final_price,
            a.total_point,
            a.status
            from orders a   join order_item b on a.orders_no=b.orders_no 
                            join member c on a.member_no=c.member_no 
                            join product d on b.product_no=d.product_no 
            where a.orders_no=:order_no";
    $order = $pdo->prepare($sql);
    $order->bindValue(":order_no",$order_no);
    $order->execute();
    $orderRows = $order->fetchAll(PDO::FETCH_ASSOC);


    $result = ["error" => false, "order" => $orderRows];
} catch (PDOException $e) {
    $result = ["error" => true, "msg" => $e->getMessage()];
    // echo "系統暫時不能正常運行，請稍後再試<br>";	
}
echo json_encode($result);

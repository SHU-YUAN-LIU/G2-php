<?php
$adminData = json_decode(file_get_contents("php://input"), true);

try {

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    // require_once("connect_chd104g2.php");

    if ($_SERVER["HTTP_HOST"] == 'localhost' || $_SERVER["HTTP_HOST"] == '127.0.0.1') {
        require_once("connect_local.php");
    } else {
        require_once("https://tibamef2e.com/chd104/g2/php/connect_chd104g2");
    }

    //建立sql指令
    $sql = "select 
	a.product_no as 'product_no',
	a.product_name as 'product_name',
	a.info as 'info',
	a.price as 'price',
	a.status as 'status',
	a.product_pic1 as 'product_pic1',
	a.product_pic2 as 'product_pic2',
	a.product_pic3 as 'product_pic3',
	a.product_pic4 as 'product_pic4',
	a.product_intro as 'product_intro',
    a.product_intro_pic1 as 'product_intro_pic1',
    a.product_intro_pic2 as 'product_intro_pic2',
    a.product_size_pic1 as 'product_size_pic1',
	b.product_class as 'product_class'
	from product a join product_class b on a.product_class_no = b.product_class_no;";
    $products = $pdo->query($sql);
    $productRows = $products->fetchAll(PDO::FETCH_ASSOC);

    $result = ["error" => false, "msg" => "", "products" => $productRows];

} catch (PDOException $e) {
    $result = ["error" => true, "msg" => $e->getMessage()];
    // echo "系統暫時不能正常運行，請稍後再試<br>";	
}
echo json_encode($result);
?>
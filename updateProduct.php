<?php 
$product_no=$_POST['product_no'];
$name=$_POST['name'];
$type=$_POST['type'];
$price=$_POST['price'];
$status=$_POST['status'];
$info=$_POST['info'];
$intro=$_POST['intro'];
$currentpic1=$_POST['currentpic1'];
$currentpic2=$_POST['currentpic2'];
$currentpic3=$_POST['currentpic3'];
$currentpic4=$_POST['currentpic4'];
$currentpic5=$_POST['currentpic5'];
$currentpic6=$_POST['currentpic6'];
$currentpic7=$_POST['currentpic7'];

ini_set("display_errors","On");
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
    $sql = "update product set 
    product_name=:name,
    product_class=:type,
    price=:price,
    status=:status,
    info=:info,
    product_intro=:intro,
    content=:content,
    product_pic1=:currentpic1,
    product_pic2=:currentpic2,
    product_pic3=:currentpic3,
    product_pic4=:currentpic4,
    product_intro_pic1=:currentpic5,
    product_intro_pic2=:currentpic6,
    product_size_pic=:currentpic7,
    where product_no=:product_no";

    

    $products = $pdo->prepare($sql);
    $products->bindValue(":name", $name);
    $products->bindValue(":type", $type);
    $products->bindValue(":price", $price);
    $products->bindValue(":status", $status);
    $products->bindValue(":info", $info);
    $products->bindValue(":intro", $intro);
    $products->bindValue(":currentpic1", $currentpic1);
    $products->bindValue(":currentpic2", $currentpic2);
    $products->bindValue(":currentpic3", $currentpic3);
    $products->bindValue(":currentpic4", $currentpic4);
    $products->bindValue(":currentpic5", $currentpic5);
    $products->bindValue(":currentpic6", $currentpic6);
    $products->bindValue(":currentpic7", $currentpic7);
    $products->bindValue(":product_no", $product_no);
    $products->execute();

	$result = ["error" => false, "msg" => "成功更新商品資料"];

} catch (PDOException $e) {
	$result = ["error" => true, "msg" => $e->getMessage()];
	// echo "系統暫時不能正常運行，請稍後再試<br>";	
}
echo json_encode($result);
?>
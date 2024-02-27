<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
$product_no=$_POST['product_no'];
$name=$_POST['name'];
$type=$_POST['type'];
$price=$_POST['price'];
$status=$_POST['status'];
$info=$_POST['info'];
$intro=$_POST['intro'];


ini_set("display_errors","On");
try {
    if($_SERVER["HTTP_HOST"]=='localhost' || $_SERVER["HTTP_HOST"] == '127.0.0.1'){
        require_once("connect_local.php");
    }else{
        // require_once("https://tibamef2e.com/chd104/g2/php/connect_chd104g2.php");
        require_once("connect_chd104g2.php");
        
    }
    
    // 查询 product_class_no
    // $getClassNoSQL = "SELECT product_class_no FROM product_class WHERE product_class = :type";
    // $getClassNoStmt = $pdo->prepare($getClassNoSQL);
    // $getClassNoStmt->bindValue(":type", $type);
    // $getClassNoStmt->execute();
    // $classNoRow = $getClassNoStmt->fetch(PDO::FETCH_ASSOC);
    // echo $classNoRow;
    // $product_class_no = $classNoRow['product_class_no'];

	//建立sql指令
    // echo $name;
    // echo $type;
    // echo $price;
    // echo $status;
    // echo $info;
    // echo $intro;
    // echo $product_no;
    $sql = "update product set 
    product_name=:name,
    product_class_no=:class_no,
    price=:price,
    status=:status,
    info=:info,
    product_intro=:intro
    where product_no=:product_no";

    

    $products = $pdo->prepare($sql);
    $products->bindValue(":name", $name);
    $products->bindValue(":class_no", $type);
    $products->bindValue(":price", $price);
    $products->bindValue(":status", $status);
    $products->bindValue(":info", $info);
    $products->bindValue(":intro", $intro);
    $products->bindValue(":product_no", $product_no);
    $products->execute();

	$result = ["error" => false, "msg" => "成功更新商品資料"];

} catch (PDOException $e) {
	$result = ["error" => true, "msg" => $e->getMessage()];
	// echo "系統暫時不能正常運行，請稍後再試<br>";	
}
echo json_encode($result);
?>
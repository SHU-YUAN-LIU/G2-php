<?php 

ini_set("display_errors","On");
try {
    
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    if($_SERVER["HTTP_HOST"]=='localhost' || $_SERVER["HTTP_HOST"] == '127.0.0.1'){
        require_once("connect_local.php");
    }else{
        require_once("connect_chd104g2.php");
    }
    $product_no=$_POST['product_no'];

    // 更新圖片部分
    $pic = $_FILES['pic']['name'];
    $extension = pathinfo($pic, PATHINFO_EXTENSION);
    $dirr='../img/';
    if(file_exists($dirr)===false){
        mkdir($dirr);
    }
    $dir='../img/product/product_data/';
    $filename='product'. $product_no . 'pic1.' . $extension;
    if(file_exists($dir)===false){
        mkdir($dir);
    }
    copy($_FILES['pic']['tmp_name'],$dir . $filename);
    //建立sql指令
    $sql = "update product set 
    product_pic1=:pic
    where product_no=:product_no";

    // 準備 SQL 語句
    $product = $pdo->prepare($sql);
    $product->bindValue(":product_no", $product_no);
    $product->bindValue(":pic", $filename);
    $product->execute();

	$result = ["error" => false, "msg" => "成功修改商品圖片"];

} catch (PDOException $e) {
	$result = ["error" => true, "msg" => $e->getMessage()];
	// echo "系統暫時不能正常運行，請稍後再試<br>";	
}
echo json_encode($result);

?>
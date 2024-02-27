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
    $product_pic1=$_FILES['product_pic1']['name'];
    $product_pic2=$_FILES['product_pic2']['name'];
    $product_pic3=$_FILES['product_pic3']['name'];
    $product_pic4=$_FILES['product_pic4']['name'];
    $product_intro_pic1=$_FILES['product_intro_pic1']['name'];
    $product_intro_pic2=$_FILES['product_intro_pic2']['name'];
    $product_size_pic1=$_FILES['product_size_pic1']['name'];

    //使用 pathinfo() 函数获取文件的扩展名。
    $extension1 = pathinfo($product_pic1, PATHINFO_EXTENSION);
    $extension2 = pathinfo($product_pic2, PATHINFO_EXTENSION);
    $extension3 = pathinfo($product_pic3, PATHINFO_EXTENSION);
    $extension4 = pathinfo($product_pic4, PATHINFO_EXTENSION);
    $extension5 = pathinfo($product_intro_pic1, PATHINFO_EXTENSION);
    $extension6 = pathinfo($product_intro_pic2, PATHINFO_EXTENSION);
    $extension7 = pathinfo($product_size_pic1, PATHINFO_EXTENSION);
    
    //指定文件存储目录，如果目录不存在则创建之。
    $dirr='../img/';
    if(file_exists($dirr)===false){
        mkdir($dirr);
    }
    $dir='../img/product/product_data/';
    $filename1='product'. $product_no . '.' . $extension1;
    $filename2='product'. $product_no . '.' . $extension2;
    $filename3='product'. $product_no . '.' . $extension3;
    $filename4='product'. $product_no . '.' . $extension4;
    $filename5='product'. $product_no . '.' . $extension5;
    $filename6='product'. $product_no . '.' . $extension6;
    $filename7='product'. $product_no . '.' . $extension7;
    if(file_exists($dir)===false){
        mkdir($dir);
    }
    // 使用 copy() 函数将上传文件保存到指定目录，并以新的文件名命名。
    copy($_FILES['product_pic1']['tmp_name'],$dir . $filename1);
    copy($_FILES['product_pic2']['tmp_name'],$dir . $filename2);
    copy($_FILES['product_pic3']['tmp_name'],$dir . $filename3);
    copy($_FILES['product_pic4']['tmp_name'],$dir . $filename4);
    copy($_FILES['product_intro_pic1']['tmp_name'],$dir . $filename5);
    copy($_FILES['product_intro_pic2']['tmp_name'],$dir . $filename6);
    copy($_FILES['product_size_pic1']['tmp_name'],$dir. $filename7);

	//建立sql指令
    $sql = "update product set 
    product_pic1=:product_pic1,
    product_pic2=:product_pic2,
    product_pic3=:product_pic3,
    product_pic4=:product_pic4,
    product_intro_pic1=:product_intro_pic1,
    product_intro_pic2=:product_intro_pic2,
    product_size_pic1=:product_size_pic1
    where product_no=:product_no";

    $journey = $pdo->prepare($sql);
    $journey->bindValue(":product_no", $product_no);
    $journey->bindValue(":product_pic1", $filename1);
    $journey->bindValue(":product_pic2", $filename2);
    $journey->bindValue(":product_pic3", $filename3);
    $journey->bindValue(":product_pic4", $filename4);
    $journey->bindValue(":product_intro_pic1", $filename5);
    $journey->bindValue(":product_intro_pic2", $filename6);
    $journey->bindValue(":product_size_pic1", $filename7);
    $journey->execute();

	$result = ["error" => false, "msg" => "成功修改商品圖片"];

} catch (PDOException $e) {
	$result = ["error" => true, "msg" => $e->getMessage()];
	// echo "系統暫時不能正常運行，請稍後再試<br>";	
}
echo json_encode($result);
?>
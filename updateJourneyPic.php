<?php 

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
    $campaign_no=$_POST['campaign_no'];
    $pic=$_FILES['pic']['name'];
    $extension = pathinfo($pic, PATHINFO_EXTENSION);
    $dir='../img/campaign/';
    $filename='campaign'. $campaign_no . '.' . $extension;
    if(file_exists($dir)===false){
        mkdir($dir);
    }
    copy($_FILES['pic']['tmp_name'],$dir . $filename);
	//建立sql指令
    $sql = "update campaign set 
    pic=:pic
    where campaign_no=:campaign_no";

    $journey = $pdo->prepare($sql);
    $journey->bindValue(":campaign_no", $campaign_no);
    $journey->bindValue(":pic", $filename);
    $journey->execute();

	$result = ["error" => false, "msg" => "成功修改活動圖片"];

} catch (PDOException $e) {
	$result = ["error" => true, "msg" => $e->getMessage()];
	// echo "系統暫時不能正常運行，請稍後再試<br>";	
}
echo json_encode($result);
?>
<?php 
$name=$_POST['name'];
$cadres=$_POST['cadres'];
$address=$_POST['address'];
$status=$_POST['status'];
$start=$_POST['start'];
$end=$_POST['end'];
$content=$_POST['content'];
$longi=$_POST['longi'];
$latti=$_POST['latti'];

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
    $sql = "insert into campaign
    (campaign_name,cadres,address,status,start_date,end_date,content,longitude,lattitude) values
    (:name,:cadres,:address,:status,:start,:end,:content,:longi,:latti)";

    $journey = $pdo->prepare($sql);
    $journey->bindValue(":name", $name);
    $journey->bindValue(":cadres", $cadres);
    $journey->bindValue(":address", $address);
    $journey->bindValue(":status", $status);
    $journey->bindValue(":start", $start);
    $journey->bindValue(":end", $end);
    $journey->bindValue(":content", $content);
    $journey->bindValue(":longi", $longi);
    $journey->bindValue(":latti", $latti);
    $journey->execute();

    $PK=$pdo->lastInsertId();


	$result = ["error" => false, "msg" => "成功更新活動資料","PK"=>$PK];

} catch (PDOException $e) {
	$result = ["error" => true, "msg" => $e->getMessage()];
	// echo "系統暫時不能正常運行，請稍後再試<br>";	
}
echo json_encode($result);
?>
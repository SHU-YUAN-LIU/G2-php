<?php
$campaign_no=$_POST["campaign_no"];
try {

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    // require_once("connect_chd104g2.php");

    if($_SERVER["HTTP_HOST"]=='localhost' || $_SERVER["HTTP_HOST"] == '127.0.0.1'){
        require_once("connect_local.php");
    }else{
        // require_once("https://tibamef2e.com/chd104/g2/php/connect_chd104g2.php");
        require_once("connect_chd104g2.php");

    }

    //建立sql指令
    $sql = "select 
    campaign_no,
	campaign_name,
    cadres,
    address,
    status,
    start_date,
    end_date,
    content,
    pic
	from campaign where campaign_no=:campaign_no;";
    $campaign = $pdo->prepare($sql);
    $campaign->bindValue(':campaign_no',$campaign_no);
    $campaign->execute();
    $campaignRows = $campaign->fetchAll(PDO::FETCH_ASSOC);

    $result = ["error" => false, "msg" => "", "campaign" => $campaignRows];

} catch (PDOException $e) {
    $result = ["error" => true, "msg" => $e->getMessage()];
    // echo "系統暫時不能正常運行，請稍後再試<br>";	
}
echo json_encode($result);
?>
<?php
// $donateData = json_decode(file_get_contents("php://input"), true);
$donateAmount = $_POST['donateAmount'];
$donateClass = $_POST['donateClass'];
$donatePoint = $_POST['donatePoint'];
echo $donatePoint;
ini_set("display_errors", "On"); 

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
	// $pdo->beginTransaction(); //sql語法(開始交易)
    $sql = "INSERT INTO donate_record (
        /* donate_no, 系統自己生成 */
        donate_class,
        donate_method,
        donate_amount,
        donate_date,
        point        
    )
    VALUES (:donate_class, :donate_method, :donate_amount, now(), :donate_point)";
    
	$donate = $pdo->prepare($sql); 
	$donate->bindValue(":donate_class", $donateClass);
    $donate->bindValue(":donate_method", "信用卡");   
    $donate->bindValue(":donate_amount", $donateAmount);
    $donate->bindValue(":donate_point", $donatePoint);
    $donate->execute();
	$result = ["error" => false, "msg" => ""];

} catch (PDOException $e) {
	$result = ["error" => true, "msg" => $e->getMessage()];
    // echo "系統暫時不能正常運行，請稍後再試<br>";	
}
echo json_encode($result);  


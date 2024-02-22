<?php
ini_set("display_errors", "On");

try {
    //許可所有來源允許訪問伺服器的資源
    header("Access-Control-Allow-Origin: *");
    //訪問方式允許進行跨域請求
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    //這個標頭指定了哪些 HTTP 標頭可以在實際的請求中使用
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    if ($_SERVER["HTTP_HOST"] == 'localhost' || $_SERVER["HTTP_HOST"] == '127.0.0.1') {
        require_once("connect_local.php");
    }else{
        // require_once("https://tibamef2e.com/chd104/g2/php/connect_chd104g2.php");
        require_once("connect_chd104g2.php");
    }

    session_start(); 
    $_SESSION = array();

    // 如果要清除的更徹底，可以同時刪除會話 cookie，會銷毀整個會話
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    session_destroy();

    echo json_encode(["message" => "Successfully logged out"]);
    } catch (Exception $e) {
        echo json_encode(["error" => true, "message" => $e->getMessage()]);
    }
?>






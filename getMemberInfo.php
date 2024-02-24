<?php
require_once __DIR__ . '/php-jwt-main/src/JWT.php';
require_once __DIR__ . '/php-jwt-main/src/Key.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$key = '您的密鑰';
// ini_set("display_errors", "On"); // 僅用於本地開發，在生產環境中應關閉

try {
    // CORS頭部信息
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    // 數據庫連接
    if ($_SERVER["HTTP_HOST"] == 'localhost' || $_SERVER["HTTP_HOST"] == '127.0.0.1') {
        require_once("connect_local.php");
    } else {
        require_once("connect_chd104g2.php");
    }

    // 處理JWT
    $authHeader = getallheaders()['Authorization'] ?? '';
    if (!$authHeader) {
        throw new Exception("未提供Token");
    }

    list($jwt) = sscanf($authHeader, 'Bearer %s');
    if (!$jwt) {
        throw new Exception("Token格式不正確");
    }

    // 解碼JWT
    $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
    $email = $decoded->sub; 

    // 從數據庫獲取會員數據
    $stmt = $pdo->prepare("SELECT * FROM member WHERE email = :member_email");
    $stmt->execute([':member_email' => $email]);
    $memberData = $stmt->fetch(PDO::FETCH_ASSOC);

    // 檢查是否找到了會員數據
    if (!$memberData) {
        throw new Exception("會員資料未找到");
    }
    
    // 準備結果
    $result = ["error" => false, "msg" => "", "memberData" => $memberData];

} catch (Exception $e) {
    // 捕獲任何異常並準備一個錯誤結果
    $result = ["error" => true, "msg" => $e->getMessage()];
}

// 返回JSON編碼的結果
echo json_encode($result);
?>



<!-- 對於存儲敏感信息，如身份驗證令牌，通常會使用 HttpOnly 的 cookie。这种 cookie 由服务器设置，不能通过客户端的 JavaScript 访问，这增加了安全性，因为即使是通过XSS攻击，攻击者也无法获得这些cookie。要设置 HttpOnly cookie，您需要在服务器端的响应中设置 Set-Cookie 头，并在 cookie 选项中添加 HttpOnly 标志。

例如，在 PHP 中，您可以这样设置一个 HttpOnly cookie：

setcookie('auth_token', 'your_secure_token', [
    'expires' => time() + 3600, // cookie有效期为1小时
    'path' => '/', // cookie的有效路径
    'secure' => true, // cookie只能通过HTTPS发送
    'httponly' => true, // cookie不能通过JavaScript访问
    'samesite' => 'Strict' // cookie的SameSite属性
]);
這樣，只有在發送HTTP請求時，這個cookie才會附加到請求中，並且僅能在相同的站點上發送，這有助於保護您的應用程序免受CSRF攻擊。 -->
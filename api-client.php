<?php

// Пример использования: php api-client.php login email password
// php api-client.php orders token
// php api-client.php change-status token order_id status_id

function apiRequest($method, $url, $data = [], $token = null)
{
    $ch = curl_init();
    $headers = ['Accept: application/json'];
    if ($token) {
        $headers[] = 'Authorization: Bearer ' . $token;
    }
    if ($method === 'GET' && !empty($data)) {
        $url .= '?' . http_build_query($data);
    }
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    if ($method !== 'GET') {
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    }
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Ошибка запроса: ' . curl_error($ch) . "\n";
        return null;
    }
    curl_close($ch);
    return $response;
}

$apiBase = 'http://localhost/api'; // Измените на свой адрес

$argv = $_SERVER['argv'];
$cmd = $argv[1] ?? null;

switch ($cmd) {
    case 'register':
        $name = $argv[2] ?? 'Test User';
        $email = $argv[3] ?? 'test@example.com';
        $password = $argv[4] ?? 'password';
        $resp = apiRequest('POST', "$apiBase/register", [
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);
        echo $resp . "\n";
        break;
    case 'login':
        $email = $argv[2] ?? '';
        $password = $argv[3] ?? '';
        $resp = apiRequest('POST', "$apiBase/login", [
            'email' => $email,
            'password' => $password,
        ]);
        echo $resp . "\n";
        break;
    case 'orders':
        $token = $argv[2] ?? '';
        $params = [];
        if (!empty($argv[3])) $params['composition'] = $argv[3]; // short|extended
        $resp = apiRequest('GET', "$apiBase/orders", $params, $token);
        echo $resp . "\n";
        break;
    case 'change-status':
        $token = $argv[2] ?? '';
        $orderId = $argv[3] ?? '';
        $statusId = $argv[4] ?? '';
        $resp = apiRequest('POST', "$apiBase/orders/$orderId/change-status", [
            'status_id' => $statusId,
        ], $token);
        echo $resp . "\n";
        break;
    default:
        echo "Доступные команды:\n";
        echo "  register name email password\n";
        echo "  login email password\n";
        echo "  orders token [composition=extended|short]\n";
        echo "  change-status token order_id status_id\n";
        break;
} 
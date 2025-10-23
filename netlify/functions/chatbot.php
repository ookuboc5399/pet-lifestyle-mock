<?php
/**
 * Netlify Functions - Chatbot API
 */

// CORS設定
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, X-Requested-With');
header('Content-Type: application/json');

// OPTIONSリクエストの処理
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// POSTリクエストのみ許可
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit();
}

// リクエストデータの取得
$input = json_decode(file_get_contents('php://input'), true);
$message = $input['message'] ?? '';

if (empty($message)) {
    http_response_code(400);
    echo json_encode(['error' => 'Message is required']);
    exit();
}

// Dify API設定
$difyApiUrl = 'https://api.dify.ai/v1/chat-messages';
$difyApiKey = $_ENV['DIFY_API_KEY'] ?? '';

if (empty($difyApiKey)) {
    http_response_code(500);
    echo json_encode(['error' => 'Dify API key not configured']);
    exit();
}

// Dify APIへのリクエスト
$data = [
    'inputs' => [],
    'query' => $message,
    'response_mode' => 'blocking',
    'conversation_id' => $input['conversation_id'] ?? null,
    'user' => $input['user'] ?? 'netlify-user'
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $difyApiUrl);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $difyApiKey,
    'Content-Type: application/json'
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode !== 200) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to communicate with Dify API']);
    exit();
}

$responseData = json_decode($response, true);

if (isset($responseData['error'])) {
    http_response_code(500);
    echo json_encode(['error' => 'Dify API error: ' . $responseData['error']]);
    exit();
}

// 成功レスポンス
echo json_encode([
    'success' => true,
    'message' => $responseData['answer'] ?? '申し訳ございません。回答を生成できませんでした。',
    'conversation_id' => $responseData['conversation_id'] ?? null
]);
?>

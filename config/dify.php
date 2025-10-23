<?php
/**
 * Dify API設定
 */

return [
    'api_url' => env('DIFY_API_URL', 'https://api.dify.ai/v1/chat-messages'),
    'api_key' => env('DIFY_API_KEY', ''),
    'app_id' => env('DIFY_APP_ID', ''),
    'timeout' => env('DIFY_TIMEOUT', 30),
    'max_retries' => env('DIFY_MAX_RETRIES', 3),
];

<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Http\Client;
use Cake\Http\Exception\BadRequestException;
use Cake\Http\Exception\InternalErrorException;
use Cake\Log\Log;

/**
 * チャットボットコントローラー
 * Dify APIとの連携を担当
 */
class ChatbotController extends Controller
{
    /**
     * Dify設定
     */
    private $difyConfig;

    /**
     * 初期化
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        
        // Dify設定を読み込み
        $this->difyConfig = \Cake\Core\Configure::read('Dify');
    }

    /**
     * チャットメッセージを送信
     */
    public function sendMessage()
    {
        $this->request->allowMethod(['post']);
        
        try {
            $data = $this->request->getData();
            $message = $data['message'] ?? '';
            
            if (empty($message)) {
                throw new BadRequestException('メッセージが入力されていません。');
            }

            // Dify APIにリクエストを送信
            $response = $this->sendToDify($message);
            
            $this->set([
                'success' => true,
                'message' => $response['message'],
                'conversation_id' => $response['conversation_id'] ?? null
            ]);
            
        } catch (\Exception $e) {
            Log::error('Chatbot API Error: ' . $e->getMessage());
            
            $this->set([
                'success' => false,
                'error' => '申し訳ございません。システムエラーが発生しました。しばらく時間をおいて再度お試しください。'
            ]);
        }
        
        $this->viewBuilder()->setOption('serialize', ['success', 'message', 'conversation_id', 'error']);
    }

    /**
     * Dify APIにメッセージを送信
     */
    private function sendToDify(string $message): array
    {
        $client = new Client();
        
        $headers = [
            'Authorization' => 'Bearer ' . $this->difyConfig['api_key'],
            'Content-Type' => 'application/json'
        ];
        
        $data = [
            'inputs' => [],
            'query' => $message,
            'response_mode' => 'blocking',
            'conversation_id' => $this->getConversationId(),
            'user' => $this->getUserId()
        ];
        
        $response = $client->post($this->difyConfig['api_url'], json_encode($data), [
            'headers' => $headers,
            'timeout' => $this->difyConfig['timeout']
        ]);
        
        if (!$response->isOk()) {
            throw new InternalErrorException('Dify APIとの通信に失敗しました。');
        }
        
        $responseData = $response->getJson();
        
        if (isset($responseData['error'])) {
            throw new InternalErrorException('Dify APIエラー: ' . $responseData['error']);
        }
        
        $conversationId = $responseData['conversation_id'] ?? null;
        if ($conversationId) {
            $this->setConversationId($conversationId);
        }
        
        // 会話履歴に保存
        $this->saveToHistory($message, $responseData['answer'] ?? '申し訳ございません。回答を生成できませんでした。');
        
        return [
            'message' => $responseData['answer'] ?? '申し訳ございません。回答を生成できませんでした。',
            'conversation_id' => $conversationId
        ];
    }

    /**
     * 会話IDを取得（セッションから）
     */
    private function getConversationId(): ?string
    {
        return $this->request->getSession()->read('chatbot.conversation_id');
    }

    /**
     * 会話IDを保存
     */
    private function setConversationId(string $conversationId): void
    {
        $this->request->getSession()->write('chatbot.conversation_id', $conversationId);
    }

    /**
     * ユーザーIDを取得（セッションから）
     */
    private function getUserId(): string
    {
        $userId = $this->request->getSession()->read('chatbot.user_id');
        
        if (!$userId) {
            $userId = 'user_' . uniqid();
            $this->request->getSession()->write('chatbot.user_id', $userId);
        }
        
        return $userId;
    }

    /**
     * 会話履歴を取得
     */
    public function getHistory()
    {
        $this->request->allowMethod(['get']);
        
        $history = $this->request->getSession()->read('chatbot.history') ?? [];
        
        $this->set([
            'success' => true,
            'history' => $history
        ]);
        
        $this->viewBuilder()->setOption('serialize', ['success', 'history']);
    }

    /**
     * 会話履歴を保存
     */
    private function saveToHistory(string $userMessage, string $botResponse): void
    {
        $history = $this->request->getSession()->read('chatbot.history') ?? [];
        
        $history[] = [
            'user' => $userMessage,
            'bot' => $botResponse,
            'timestamp' => date('Y-m-d H:i:s')
        ];
        
        // 履歴を最新20件に制限
        if (count($history) > 20) {
            $history = array_slice($history, -20);
        }
        
        $this->request->getSession()->write('chatbot.history', $history);
    }

    /**
     * 会話をリセット
     */
    public function reset()
    {
        $this->request->allowMethod(['post']);
        
        $this->request->getSession()->delete('chatbot');
        
        $this->set([
            'success' => true,
            'message' => '会話がリセットされました。'
        ]);
        
        $this->viewBuilder()->setOption('serialize', ['success', 'message']);
    }
}

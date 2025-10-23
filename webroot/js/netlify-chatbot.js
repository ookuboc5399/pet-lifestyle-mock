/**
 * Netlify用チャットボット機能
 */

document.addEventListener('DOMContentLoaded', function() {
    // チャットボット機能の初期化
    initNetlifyChatbot();
});

/**
 * Netlify用チャットボット機能の初期化
 */
function initNetlifyChatbot() {
    console.log('Initializing Netlify chatbot...');
    const chatbotButton = document.getElementById('chatbot-button');
    const chatbotModal = document.getElementById('chatbotModal');
    
    console.log('Chatbot button:', chatbotButton);
    console.log('Chatbot modal:', chatbotModal);
    
    if (!chatbotButton || !chatbotModal) {
        console.warn('Chatbot elements not found');
        return;
    }
    
    console.log('Netlify chatbot initialized successfully');
    
    // チャットボットボタンのクリックイベント
    chatbotButton.addEventListener('click', function() {
        console.log('Chatbot button clicked');
        const modal = new bootstrap.Modal(chatbotModal);
        modal.show();
    });
    
    // リセットボタンのクリックイベント
    const chatbotReset = document.getElementById('chatbot-reset');
    if (chatbotReset) {
        chatbotReset.addEventListener('click', function() {
            const iframe = document.querySelector('#chatbotModal iframe');
            if (iframe) {
                iframe.src = iframe.src; // iframeをリロード
            }
        });
    }
    
    // メッセージ送信関数（Netlify Functions使用）
    function sendMessage() {
        const message = document.getElementById('chatbot-input')?.value?.trim();
        if (!message) return;
        
        // ユーザーメッセージを表示
        addMessage(message, 'user');
        document.getElementById('chatbot-input').value = '';
        
        // ローディング表示
        const loadingId = addLoadingMessage();
        
        // Netlify Functionsへのリクエスト
        fetch('/.netlify/functions/chatbot', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                message: message
            })
        })
        .then(response => response.json())
        .then(data => {
            removeLoadingMessage(loadingId);
            if (data.success) {
                addMessage(data.message, 'bot');
            } else {
                addMessage(data.error || 'エラーが発生しました。', 'bot');
            }
        })
        .catch(error => {
            removeLoadingMessage(loadingId);
            console.error('Error:', error);
            addMessage('申し訳ございません。システムエラーが発生しました。', 'bot');
        });
    }
    
    // メッセージ追加関数
    function addMessage(content, type) {
        const chatbotMessages = document.getElementById('chatbot-messages');
        if (!chatbotMessages) return;
        
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${type}-message`;
        
        const contentDiv = document.createElement('div');
        contentDiv.className = 'message-content';
        contentDiv.innerHTML = content;
        
        messageDiv.appendChild(contentDiv);
        chatbotMessages.appendChild(messageDiv);
        
        // スクロールを最下部に
        chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
        
        // アニメーション
        messageDiv.classList.add('fade-in-up');
    }
    
    // ローディングメッセージ追加
    function addLoadingMessage() {
        const chatbotMessages = document.getElementById('chatbot-messages');
        if (!chatbotMessages) return null;
        
        const loadingId = 'loading-' + Date.now();
        const messageDiv = document.createElement('div');
        messageDiv.id = loadingId;
        messageDiv.className = 'message bot-message';
        
        const contentDiv = document.createElement('div');
        contentDiv.className = 'message-content';
        contentDiv.innerHTML = '<div class="loading"></div> AIが回答を生成中...';
        
        messageDiv.appendChild(contentDiv);
        chatbotMessages.appendChild(messageDiv);
        chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
        
        return loadingId;
    }
    
    // ローディングメッセージ削除
    function removeLoadingMessage(loadingId) {
        const loadingElement = document.getElementById(loadingId);
        if (loadingElement) {
            loadingElement.remove();
        }
    }
}

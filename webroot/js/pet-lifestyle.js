/**
 * ペットライフスタイル株式会社 - カスタムJavaScript
 */

document.addEventListener('DOMContentLoaded', function() {
    // チャットボット機能の初期化
    initChatbot();
    
    // スムーススクロールの初期化
    initSmoothScroll();
    
    // アニメーションの初期化
    initAnimations();
});

/**
 * チャットボット機能の初期化
 */
function initChatbot() {
    console.log('Initializing chatbot...');
    const chatbotButton = document.getElementById('chatbot-button');
    const chatbotModal = document.getElementById('chatbotModal');
    
    console.log('Chatbot button:', chatbotButton);
    console.log('Chatbot modal:', chatbotModal);
    
    if (!chatbotButton || !chatbotModal) {
        console.warn('Chatbot elements not found');
        return;
    }
    
    console.log('Chatbot initialized successfully');
    
    // チャットボットボタンのクリックイベント
    chatbotButton.addEventListener('click', function() {
        console.log('Chatbot button clicked');
        const modal = new bootstrap.Modal(chatbotModal);
        modal.show();
    });
    
    // リセットボタンのクリックイベント（iframeの場合はリロード）
    const chatbotReset = document.getElementById('chatbot-reset');
    if (chatbotReset) {
        chatbotReset.addEventListener('click', function() {
            const iframe = document.querySelector('#chatbotModal iframe');
            if (iframe) {
                iframe.src = iframe.src; // iframeをリロード
            }
        });
    }
}

/**
 * スムーススクロールの初期化
 */
function initSmoothScroll() {
    // アンカーリンクのスムーススクロール
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}

/**
 * アニメーションの初期化
 */
function initAnimations() {
    // Intersection Observer for scroll animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in-up');
            }
        });
    }, observerOptions);
    
    // アニメーション対象要素を監視
    document.querySelectorAll('.card, .list-group-item, .accordion-item').forEach(el => {
        observer.observe(el);
    });
}

/**
 * ユーティリティ関数
 */

// デバウンス関数
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// スロットル関数
function throttle(func, limit) {
    let inThrottle;
    return function() {
        const args = arguments;
        const context = this;
        if (!inThrottle) {
            func.apply(context, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}

// フォームバリデーション
function validateForm(form) {
    const inputs = form.querySelectorAll('input[required], textarea[required], select[required]');
    let isValid = true;
    
    inputs.forEach(input => {
        if (!input.value.trim()) {
            input.classList.add('is-invalid');
            isValid = false;
        } else {
            input.classList.remove('is-invalid');
        }
    });
    
    return isValid;
}

// 成功メッセージ表示
function showSuccessMessage(message) {
    const alertDiv = document.createElement('div');
    alertDiv.className = 'alert alert-success alert-dismissible fade show';
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    const container = document.querySelector('.container');
    if (container) {
        container.insertBefore(alertDiv, container.firstChild);
    }
}

// エラーメッセージ表示
function showErrorMessage(message) {
    const alertDiv = document.createElement('div');
    alertDiv.className = 'alert alert-danger alert-dismissible fade show';
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    const container = document.querySelector('.container');
    if (container) {
        container.insertBefore(alertDiv, container.firstChild);
    }
}

// ページトップに戻る
function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}

// 外部リンクの処理
document.addEventListener('click', function(e) {
    if (e.target.tagName === 'A' && e.target.hostname !== window.location.hostname) {
        e.target.target = '_blank';
        e.target.rel = 'noopener noreferrer';
    }
});

// レスポンシブ対応
function handleResize() {
    const isMobile = window.innerWidth <= 768;
    
    // モバイル用の処理
    if (isMobile) {
        // モバイル特有の処理
        document.body.classList.add('mobile');
    } else {
        document.body.classList.remove('mobile');
    }
}

// リサイズイベントの処理
window.addEventListener('resize', debounce(handleResize, 250));

// 初期化
handleResize();

<?php
/**
 * ペットライフスタイル株式会社 - モックサイト
 * @var \App\View\AppView $this
 */
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        ペットライフスタイル株式会社 - <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <?= $this->Html->css('pet-lifestyle') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="<?= $this->Url->build('/') ?>">
                <i class="fas fa-paw me-2"></i>ペットライフスタイル株式会社
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $this->Url->build('/') ?>">HOME</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            資格の活用事例
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">新築編</a></li>
                            <li><a class="dropdown-item" href="#">分譲編</a></li>
                            <li><a class="dropdown-item" href="#">中古リノベーション編</a></li>
                            <li><a class="dropdown-item" href="#">賃貸編</a></li>
                            <li><a class="dropdown-item" href="#">イベント編</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            提供サービス
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">PAWs Style（住宅プラン集）</a></li>
                            <li><a class="dropdown-item" href="#">定額営業支援サービス「パウスク！」</a></li>
                            <li><a class="dropdown-item" href="#">AMILIE MAGAZINE</a></li>
                            <li><a class="dropdown-item" href="#">無料集客webサイト「AMILIE」</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">おすすめ建材・設備</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">ペットライフスタイルについて</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">無料オンラインセミナー</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">資格取得の講座案内</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $this->Url->build('/chat') ?>">
                            <i class="fas fa-robot me-1"></i>AIチャット
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-light py-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="mb-3">ペットライフスタイル株式会社</h5>
                    <p class="mb-2">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        〒105-0004 東京都港区新橋2-16-1 ニュー新橋ビル518
                    </p>
                    <p class="mb-2">
                        <i class="fas fa-phone me-2"></i>
                        Phone: 03-6268-8612
                    </p>
                    <p class="mb-0">
                        <i class="fas fa-fax me-2"></i>
                        Fax: 03-6268-8656
                    </p>
                </div>
                <div class="col-md-6">
                    <h5 class="mb-3">リンク</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-light text-decoration-none">HOME</a></li>
                        <li><a href="#" class="text-light text-decoration-none">資格の活用事例</a></li>
                        <li><a href="#" class="text-light text-decoration-none">提供サービス</a></li>
                        <li><a href="#" class="text-light text-decoration-none">無料オンラインセミナー</a></li>
                        <li><a href="#" class="text-light text-decoration-none">資格取得の講座案内</a></li>
                    </ul>
                </div>
            </div>
            <hr class="my-4">
            <div class="text-center">
                <p class="mb-0">&copy; 2019 ペットライフスタイル株式会社 All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Chat Bot Button -->
    <div id="chatbot-button" class="chatbot-toggle">
        <i class="fas fa-comments"></i>
    </div>

    <!-- Chat Bot Modal -->
    <div class="modal fade" id="chatbotModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-robot me-2"></i>ペットライフスタイル AI アシスタント
                    </h5>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-light btn-sm" id="chatbot-reset" title="会話をリセット">
                            <i class="fas fa-refresh"></i>
                        </button>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                </div>
                <div class="modal-body p-0">
                    <!-- Dify iframeチャットアプリ -->
                    <iframe
                        src="https://udify.app/chatbot/YBbJEzBRr3IyodV7"
                        style="width: 100%; height: 100%; min-height: 700px"
                        frameborder="0"
                        allow="microphone">
                    </iframe>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <?= $this->Html->script('pet-lifestyle') ?>
</body>
</html>

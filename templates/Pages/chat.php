<?php
/**
 * ペットライフスタイル株式会社 - チャットページ
 * @var \App\View\AppView $this
 */
?>

<?php $this->assign('title', 'AIチャット'); ?>

<!-- チャットページ -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center mb-4">
                    <i class="fas fa-robot me-2"></i>ペットライフスタイル AI アシスタント
                </h1>
                <p class="text-center text-muted mb-5">
                    ペットとの住まいについて、何でもお気軽にお聞きください。
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body p-0">
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
        <div class="row mt-4">
            <div class="col-12 text-center">
                <a href="<?= $this->Url->build('/') ?>" class="btn btn-primary">
                    <i class="fas fa-home me-2"></i>ホームに戻る
                </a>
            </div>
        </div>
    </div>
</section>

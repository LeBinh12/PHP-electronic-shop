<?php
require 'vendor/autoload.php';

use GuzzleHttp\Client;
// use Parsedown;

$isChatOpenAi = $_SESSION['chat_open_ai'] ?? false;

if (isset($_GET['closeChatAi'])) {
    unset($_SESSION['chat_open_ai']);
    exit;
}



if (!isset($_SESSION['chat_history'])) {
    $_SESSION['chat_history'] = [];
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ai_message'])) {

    $message = trim($_POST['ai_message']);
    $apiKey = 'AIzaSyAu1vhxh5QbmVGqZ9CmKNg6SSb-Ot-J1Bc';
    $client = new Client();

    if (strlen($message) > 500) {
        swal_alert('error', 'Lỗi gửi tin nhắn', 'Bạn không được nhiều quá 500 ký tự', "Index.php");
    } else {

        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}";

        $prompt = "Bạn là một trợ lý chuyên tư vấn về đồ điện tử cho trang web bán các đồ điện tự.
     Hãy gợi ý cho người dùng bằng tiếng Việt, dựa trên yêu cầu sau: \"{$message}\" và trả lời ngắn gọn giúp tôi";

        $requestBody = [
            'contents' => [
                [
                    'parts' => [
                        [
                            'text' => $prompt
                        ]
                    ]
                ]
            ]
        ];

        try {
            $response = $client->post($url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'json' => $requestBody,
            ]);

            $result = json_decode($response->getBody(), true);
            $aiChatResponse = $result['candidates'][0]['content']['parts'][0]['text'] ?? 'Không có phản hồi.';

            $timestamp = date('H:i d/m/Y');
            $_SESSION['chat_history'][] = [
                'user_message' => $message,
                'ai_response' => $aiChatResponse,
                'timestamp' => $timestamp
            ];
            $_SESSION['chat_open_ai'] = true;
            echo '<meta http-equiv="refresh" content="0">';
        } catch (Exception $e) {
            $aiChatResponse = "Lỗi gọi API: " . $e->getMessage();
        }
    }
} else {
    $aiChatResponse = '';
}
?>

<div id="ai-chat-form" class="chat-box <?= $isChatOpenAi ? '' : 'hidden' ?>">
    <div class="p-2 bg-primary text-white d-flex justify-content-between align-items-center" style="border-radius: 8px 8px 0 0;">
        <!-- Bên trái: Avatar + Tiêu đề -->
        <div class="d-flex align-items-center">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQO42z2p6t2s8Sv8gkV_R1aMeIyfmIQR_ss7w&s"
                alt="AI Avatar"
                class="rounded-circle me-2"
                style="width: 36px; height: 36px; object-fit: cover;">
            <p class="m-0 fw-bold">Hỗ trợ AI</p>
        </div>

        <!-- Nút đóng -->
        <i id="ai-chat-close" class="bi bi-x-lg" style="cursor: pointer;"></i>
    </div>
    <div id="ai-chat-content" class="p-2" style="background: #f8f9fa; min-height: 399px; max-height: 399px; overflow-y: auto;">
        <?php if (empty($_SESSION['chat_history'])): ?>
            <div class="text-center text-muted" style="margin-top: 150px;">
                <i class="bi bi-chat-dots fs-1"></i>
                <p class="mt-2">Chưa có tin nhắn</p>
            </div>
        <?php else: ?>

            <?php foreach ($_SESSION['chat_history'] as $i => $chat) {
                $isLast = $i === array_key_last($_SESSION['chat_history']);
            ?>
                <div class="d-flex justify-content-end mb-2 flex-column align-items-end">
                    <div class="p-2 bg-primary text-white border rounded">
                        <?= htmlspecialchars($chat['user_message']) ?>
                    </div>
                    <div class="small text-muted mt-1"><?= $chat['timestamp'] ?></div>
                </div>

                <div class="d-flex align-items-start mb-2 flex-column">
                    <div class="d-flex" style="max-width: 80%;">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQO42z2p6t2s8Sv8gkV_R1aMeIyfmIQR_ss7w&s"
                            class="rounded-circle me-2" style="width: 30px; height: 30px;">
                        <div class="p-2 bg-light border rounded ai-response-text <?= $isLast ? 'new' : '' ?>">
                            <?php
                            $Parsedown = new Parsedown();
                            $htmlFormatted = $Parsedown->text($chat['ai_response']);
                            echo  $htmlFormatted  ?>
                        </div>
                    </div>
                    <div class="small text-muted mt-1" style="margin-left: 40px;"><?= $chat['timestamp'] ?></div>
                </div>
            <?php } ?>
        <?php endif; ?>

    </div>
    <form method="POST" class="border-top d-flex align-items-center">
        <input type="text" class="form-control me-2" style="border: none; box-shadow: none; outline: none;" name="ai_message" placeholder="Nhập tin nhắn..." required>
        <button type="submit" class="btn"><i class="bi bi-send-fill text-green fs-4"></i>
        </button>
    </form>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("ai-chat-close").addEventListener("click", () => {
            fetch("?closeChatAi=1").then(() => {
                document.getElementById("ai-chat-form").classList.add("hidden");
            });
        });

        const content = document.getElementById("ai-chat-content");
        content.scrollTop = content.scrollHeight;

        const responses = document.querySelectorAll(".ai-response-text.new");
        responses.forEach(el => {
            const fullText = el.innerHTML;
            el.innerHTML = "";
            let index = 0;

            const typeEffect = () => {
                if (index < fullText.length) {
                    el.innerHTML += fullText[index];
                    index++;
                    setTimeout(typeEffect, 10); // tốc độ gõ
                }
            };

            typeEffect();
        });

    });
</script>
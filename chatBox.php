<?php
require 'vendor/autoload.php';

use GuzzleHttp\Client;

$isChatOpenAi = $_SESSION['chat_open_ai'] ?? false;

if (isset($_GET['closeChatAi'])) {
    unset($_SESSION['chat_open_ai']);
    exit;
}



if (!isset($_SESSION['chat_history'])) {
    $_SESSION['chat_history'] = [];
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ai_message'])) {

    $message = $_POST['ai_message'];
    $apiKey = 'AIzaSyAu1vhxh5QbmVGqZ9CmKNg6SSb-Ot-J1Bc';
    $client = new Client();
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
} else {
    $aiChatResponse = '';
}
?>

<div id="ai-chat-form" class="chat-box <?= $isChatOpenAi ? '' : 'hidden' ?>">
    <div class="p-2 bg-primary text-white d-flex justify-content-between align-items-center" style="border-radius: 8px 8px 0 0;">
        <p class="m-0">Hỗ trợ AI</p>
        <i id="ai-chat-close" class="bi bi-x-lg" style="cursor: pointer;"></i>
    </div>
    <div id="ai-chat-content" class="p-2" style="background: #f8f9fa; min-height: 405px; max-height: 500px; overflow-y: auto;">
        <?php foreach ($_SESSION['chat_history'] as $chat) { ?>
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
                    <div class="p-2 bg-light border rounded">
                        <?= htmlspecialchars($chat['ai_response']) ?>
                    </div>
                </div>
                <div class="small text-muted mt-1" style="margin-left: 40px;"><?= $chat['timestamp'] ?></div>
            </div>
        <?php } ?>

    </div>
    <form method="POST" class="border-top d-flex align-items-center">
        <input type="text" class="form-control me-2" style="border: none; box-shadow: none; outline: none;" name="ai_message" placeholder="Nhập tin nhắn..." required>
        <button type="submit" class="btn">
            <i class="bi bi-send-fill text-green fs-4"></i>
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
    });
</script>
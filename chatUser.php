<?php
if (!isset($chatController) || !isset($userData)) return;

$userId = $userData->id ?? null;
if (!$userId) return;

$isChatOpen = $_SESSION['chat_open'] ?? false;



if (isset($_GET['closeChat'])) {
    unset($_SESSION['chat_open']);
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message']) && $userId) {
    $message = trim($_POST['message']);
    if ($message !== '') {
        $result = $chatController->sendMessage($userId, ['sender_role' => 'user'], $message);
        if ($result['success']) {
            $_SESSION['chat_open'] = true;
            echo '<meta http-equiv="refresh" content="0">';
        }
    }
}

$messages = $chatController->getChatHistory($userId);
?>

<div id="chat-form" class="chat-box <?= $isChatOpen ? '' : 'hidden' ?>">
    <div class="p-2 bg-primary text-white d-flex justify-content-between align-items-center" style="border-radius: 8px 8px 0 0;">
        <div class="d-flex align-items-center">
            <img src="data:image/jpeg;base64,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" alt="Logo" style="width: 36px; height: 36px; border-radius: 50%; margin-right: 10px;">
            <div style="line-height: 1;">
                <div style="font-weight: bold; font-size: 18px; margin-bottom: 5px;">GARENA</div>
                <div style="font-size: 13px;">Chat với chúng tôi</div>
            </div>
        </div>
        <i id="chat-close" class="bi bi-x-lg" style="cursor: pointer; font-size: 18px;"></i>
    </div>


    <div id="chat-content" class="p-2" style="background: #f8f9fa; max-height: 500px; overflow-y: auto;">
        <?php foreach ($messages as $msg) { ?>
            <?php if ($msg->from === 'admin') { ?>
                <div class="d-flex align-items-start mb-2 flex-column">
                    <div class="d-flex" style="max-width: 80%;">
                        <img src="data:image/jpeg;base64,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"
                            class="rounded-circle me-2" style="width: 30px; height: 30px;">
                        <div class="p-2 rounded bg-light border">
                            <?= htmlspecialchars($msg->message) ?>
                        </div>
                    </div>
                    <div class="small text-muted" style="margin-left: 40px;"><?= $msg->time ?></div>
                </div>
            <?php } else { ?>
                <div class="mb-2 text-end">
                    <div class="d-inline-block p-2 rounded bg-primary text-white">
                        <?= htmlspecialchars($msg->message) ?>
                    </div>
                    <div class="small text-muted"><?= $msg->time ?></div>
                </div>
            <?php } ?>
        <?php } ?>
    </div>


    <form method="POST" class="p-2 border-top d-flex align-items-center">
        <input type="text" name="message" class="form-control me-2" style="border: none; box-shadow: none; outline: none;" placeholder="Nhập tin nhắn..." required>
        <button type="submit" class="btn">
            <i class="bi bi-send text-primary fs-4"></i>
        </button>
    </form>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        const chatForm = document.getElementById("chat-form");
        const chatToggle = document.getElementById("chat-toggle-admin");

        if (chatToggle) {
            chatToggle.addEventListener("click", () => {
                chatForm.classList.toggle("hidden");
                fetch("?openChat=1");

                setTimeout(() => scrollChatToBottom(), 100);
            });
        }

        document.getElementById("chat-close").addEventListener("click", () => {
            chatForm.classList.add("hidden");
            fetch("?closeChat=1");
        });

        if (!chatForm.classList.contains("hidden")) {
            scrollChatToBottom();
        }

        function scrollChatToBottom() {
            const chatContent = document.getElementById("chat-content");
            chatContent.scrollTop = chatContent.scrollHeight;
        }
    });
</script>
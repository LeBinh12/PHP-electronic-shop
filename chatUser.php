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
        $chatController->sendMessage($userId, 'user', $message);
        $_SESSION['chat_open'] = true;
        echo "<script>
                alert('Đã gửi tin nhắn thành công!');
                window.location.href = 'Index.php';
            </script>";
    }
}

$messages = $chatController->getChatHistory($userId);
?>

<div id="chat-form" class="chat-box <?= $isChatOpen ? '' : 'hidden' ?>">
    <div class="p-2 bg-primary text-white d-flex justify-content-between align-items-center">
        <p class="m-0">Hỗ trợ trực tuyến</p>
        <i id="chat-close" class="bi bi-x-lg" style="cursor: pointer;"></i>
    </div>

    <div id="chat-content" class="p-2" style="background: #f8f9fa; max-height: 500px; overflow-y: auto;">
        <?php foreach ($messages as $msg) { ?>
            <div class="mb-2 <?= $msg->from === 'user' ? 'text-end' : 'text-start' ?>">
                <div class="d-inline-block p-2 rounded <?= $msg->from === 'user' ? 'bg-primary text-white' : 'bg-light border' ?>">
                    <?= htmlspecialchars($msg->message) ?>
                </div>
                <div class="small text-muted"><?= $msg->time ?></div>
            </div>
        <?php } ?>
    </div>

    <form method="POST" class="p-2 border-top d-flex align-items-center">
        <input type="text" name="message" class="form-control me-2" placeholder="Nhập tin nhắn..." required>
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-send-fill"></i>
        </button>
    </form>
</div>


<script>
    document.getElementById("chat-close").addEventListener("click", () => {
        const chatForm = document.getElementById("chat-form");
        chatForm.classList.add("hidden");
        fetch("?closeChat=1");
    });
</script>
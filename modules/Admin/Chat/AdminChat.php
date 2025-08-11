<?php
if (!isset($chatController) || !isset($userController)) return;




$messages = $userId ? $chatController->getChatHistory($userId) : [];
?>




<!-- Form tin nhắn khi đã chọn người dùng -->

<?php if ($userId) { ?>
    <div id="chat-form" class="chat-box-admin">
        <div class="p-2 bg-success text-white d-flex justify-content-between align-items-center" style="border-radius: 8px 8px 0 0;">
            <p class="m-0">Chat với User #<?= $userController->getById($userId)['FullName'] ?? "Không có tên" ?></p>
            <a href="Admin.php" class="text-white"><i class="bi bi-x-lg"></i></a>
        </div>

        <div id="chat-content" class="p-2 overflow-auto" style="background: #f8f9fa; max-height: 400px;">
            <?php foreach ($messages as $msg) { ?>
                <?php if ($msg->from === 'user') { ?>
                    <div class="d-flex align-items-start mb-2" style="margin-right: 100px;">
                        <img src="https://tse4.mm.bing.net/th?id=OIP.kQyrx9VbuWXWxCVxoreXOgHaHN&pid=Api&P=0&h=220"
                            class="rounded-circle me-2" style="width: 30px; height: 30px;">
                        <div>
                            <strong>User</strong>
                            <div class="p-2 bg-light border rounded"><?= htmlspecialchars($msg->message) ?></div>
                            <div class="small text-muted"><?= $msg->time ?></div>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="d-flex justify-content-end mb-2" style="margin-left: 100px;">
                        <div>
                            <div class="p-2 bg-success text-white rounded"><?= htmlspecialchars($msg->message) ?></div>
                            <div class="small text-muted text-end"><?= $msg->time ?></div>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>

        <form method="POST" class="p-2 border-top d-flex align-items-center">
            <input type="hidden" name="userId" value="<?= $userId ?>">
            <input type="text" name="message" class="form-control me-2" style="border: none; box-shadow: none; outline: none;" placeholder="Nhập tin nhắn..." required>
            <button type="submit" class="btn">
                <i class="bi bi-send-fill text-success fs-4"></i>
            </button>
        </form>
    </div>
<?php } ?>

<?php
// Gửi tin nhắn
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'], $_POST['userId'])) {
    $msg = trim($_POST['message']);
    $toUser = (int)$_POST['userId'];
    if ($msg !== '') {
        $chatController->sendMessage($toUser, ['sender_id' => 1, 'sender_role' => 'admin'], $msg);
        echo "<script>
                window.location.href = '?chat_user_id=$toUser';
            </script>";
    }
}
?>

<script>
    window.addEventListener('DOMContentLoaded', () => {
        const chatContent = document.getElementById('chat-content');
        if (chatContent) {
            chatContent.scrollTop = chatContent.scrollHeight;
        }
    });
</script>
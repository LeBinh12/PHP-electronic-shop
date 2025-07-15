<?php
if (!isset($chatController) || !isset($userController)) return;

$userList = $chatController->getAllChatUserIdsFromRedis();
$userId = $_GET['chat_user_id'] ?? null;
$showChatList = isset($_GET['show_chat_list']);


$messages = $userId ? $chatController->getChatHistory($userId) : [];
?>

<div style="position: fixed; bottom: 30px; right: 10%;">
    <a href="?show_chat_list=1" class="btn btn-primary">Danh sách tin nhắn đến</a>
</div>
<?php if ($showChatList) { ?>
    <div style="position: fixed; bottom: 90px; right: 10%; width: 200px; height: 400px; overflow-y: auto; background: #f1f1f1; border-radius: 10px;" class="p-2">
        <h6>Khách hàng</h6>
        <ul class="list-unstyled">
            <?php foreach ($userList as $user) { ?>
                <li>
                    <a href="?chat_user_id=<?= $user ?>" class="text-decoration-none">
                        <?= htmlspecialchars($user) ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
        <a href="Admin.php" class="text-decoration-none">Đóng</a>
    </div>
<?php } ?>
<!-- Sidebar chọn người dùng -->
<div style="position: fixed; bottom: 80px; left: 20px; width: 200px; height: 400px; overflow-y: auto; background: #f1f1f1; border-radius: 10px;" class="p-2">
    <h6>Khách hàng</h6>
    <ul class="list-unstyled">
        <?php foreach ($userList as $user) { ?>
            <li>
                <a href="?chat_user_id=<?= $user ?>" class="text-decoration-none">
                    <?= htmlspecialchars($user) ?>
                </a>
            </li>
        <?php } ?>
    </ul>
</div>

<?php if ($userId) { ?>
    <div id="chat-form" class="chat-box-admin">
        <div class="p-2 bg-success text-white d-flex justify-content-between align-items-center">
            <p class="m-0">Chat với User #<?= $userId ?></p>
            <a href="Admin.php" class="text-white"><i class="bi bi-x-lg"></i></a>
        </div>

        <div id="chat-content" class="p-2 overflow-auto" style="background: #f8f9fa; max-height: 400px;">
            <?php foreach ($messages as $msg) { ?>
                <?php if ($msg->from === 'user') { ?>
                    <div class="d-flex align-items-start mb-2">
                        <img src="https://tse4.mm.bing.net/th?id=OIP.kQyrx9VbuWXWxCVxoreXOgHaHN&pid=Api&P=0&h=220"
                            class="rounded-circle me-2" style="width: 30px; height: 30px;">
                        <div>
                            <strong>User</strong>
                            <div class="p-2 bg-light border rounded"><?= htmlspecialchars($msg->message) ?></div>
                            <div class="small text-muted"><?= $msg->time ?></div>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="d-flex justify-content-end mb-2">
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
            <input type="text" name="message" class="form-control me-2" placeholder="Nhập tin nhắn..." required>
            <button type="submit" class="btn btn-success"><i class="bi bi-send-fill"></i></button>
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
                alert('trả lời khách hàng thành công!');
                window.location.href = '?chat_user_id=$toUser';
            </script>";
    }
}
?>
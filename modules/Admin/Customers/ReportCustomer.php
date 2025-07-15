<?php
// $reportReasons = $reportController->getAll();

// if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['report'])) {
//     $user_id = $_POST['reported_user_id'];
//     $reason_id = $_POST['reason_id'];
//     $reason = $reportController->getById($reason_id);
//     $banned_by_user_id = 1;
//     $banned_by_role = 'admin';
//     $banned_from = new DateTime();
//     $banned_until = (clone $banned_from)->modify("+{$reason['ban_days']} days");
//     $data = [
//         'reported_user_id' => $user_id,
//         'reason_id' => $reason_id,
//         'banned_by_user_id' => $banned_by_user_id,
//         'banned_by_role' => $banned_by_role,
//         'banned_from' => $banned_from->format('Y-m-d H:i:s'),
//         'banned_until' => $banned_until->format('Y-m-d H:i:s'),
//         'isDeleted' => 0
//     ];

//     $result = $userReportController->add($data);
//     if ($result['success']) {
//         echo "<script>
//                 alert('Báo cáo khách hàng thành công!');
//                 window.location.href = 'Admin.php?page=modules/Admin/Customers/Customer.php';
//             </script>";
//         exit;
//     } else {
//         echo "Lỗi " . $result['message'];
//         exit;
//     }
// }
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['report'])) {
    $user_id = $_POST['reported_user_id'];
    $reason_id = $_POST['reason_id'];
    $description = $_POST['description'] ?? null;

    $reason = $reportController->getById($reason_id);

    $banned_by_user_id = 1;
    $banned_by_role = 'admin';

    $now = new DateTime();
    $currentBan = $userReportController->getByUserId($user_id);
    $newBanUntil = (clone $now)->modify("+{$reason['ban_days']} days");

    if ($currentBan && strtotime($currentBan['banned_until']) > time()) {
        $oldBanUntil = new DateTime($currentBan['banned_until']);

        if ($newBanUntil > $oldBanUntil) {
            $updateData = [
                'reason_id' => $reason_id,
                'description' => $description,
                'banned_from' => $now->format('Y-m-d H:i:s'),
                'banned_until' => $newBanUntil->format('Y-m-d H:i:s'),
                'updated_at' => $now->format('Y-m-d H:i:s'),
            ];
            $result = $userReportController->updateBan($user_id, $updateData);
        } else {
            $result = ['success' => false, 'message' => 'Người dùng đã bị cấm với thời hạn dài hơn.'];
        }
    } else {
        $data = [
            'reported_user_id' => $user_id,
            'reason_id' => $reason_id,
            'description' => $description,
            'banned_by_user_id' => $banned_by_user_id,
            'banned_by_role' => $banned_by_role,
            'banned_from' => $now->format('Y-m-d H:i:s'),
            'banned_until' => $newBanUntil->format('Y-m-d H:i:s'),
            'isDeleted' => 0
        ];
        $result = $userReportController->add($data);
    }

    if ($result['success']) {
        echo "<script>
                alert('Báo cáo khách hàng thành công!');
                window.location.href = 'Admin.php?page=modules/Admin/Customers/Customer.php';
            </script>";
        exit;
    } else {
        echo "Lỗi: " . $result['message'];
        exit;
    }
}


?>

<!-- Modal Báo cáo khách hàng -->
<div class="modal fade" id="reportCustomerModal" tabindex="-1" aria-labelledby="reportCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title" id="reportCustomerModalLabel">Báo cáo người dùng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="reported_user_id" id="report-user-id">

                    <div class="mb-3">
                        <label for="reason_id" class="form-label">Lý do báo cáo</label>
                        <select name="reason_id" id="reason_id" class="form-select" required>
                            <option value="">-- Chọn lý do --</option>
                            <?php foreach ($reportReasons as $reason): ?>
                                <option value="<?= $reason['id'] ?>">
                                    <?= htmlspecialchars($reason['reason_text']) ?> (<?= $reason['ban_days'] ?> ngày cấm)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="report_description" class="form-label">Mô tả chi tiết</label>
                        <textarea name="description" id="report_description" class="form-control" rows="3"
                            placeholder="Ghi rõ hành vi vi phạm, tình huống cụ thể..."></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning" name="report">Gửi báo cáo</button>
                </div>
            </div>
        </form>
    </div>
</div>

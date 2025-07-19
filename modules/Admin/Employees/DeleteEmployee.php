<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_employee'])) {
    $id = $_POST['delete_employee_id'];
    $result = $employeeController->delete($id);

    if ($result['success']) {
        $_SESSION['success'] = $result['message'];
    } else {
        $_SESSION['error'] = $result['message'];
    }

    echo "<script>window.location.href = 'Admin.php?page=modules/Admin/Employees/Employee.php';</script>";
    exit;
}
?>


<div class="modal fade" id="deleteEmployeeModal" tabindex="-1" aria-labelledby="deleteEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteEmployeeModalLabel">Xác nhận xóa nhân viên</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body">
                    Bạn có chắc chắn muốn xóa nhân viên: <strong id="deleteEmployeeName"></strong>?
                    <input type="hidden" name="delete_employee_id" id="deleteEmployeeId">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" name="delete_employee" class="btn btn-danger">Xóa</button>
                </div>
            </div>
        </form>
    </div>
</div>
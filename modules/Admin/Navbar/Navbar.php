<nav class="navbar navbar-expand-lg fixed-top shadow-sm"
    style="background: #f4f6f8; width: calc(100% - 250px); margin-left: 250px; box-shadow: 2px 0 8px rgba(0, 0, 0, 0.08);"
    data-bs-theme="dark">
    <div class="container-fluid">
        <span class="navbar-brand" style="font-weight: 600; font-size: 1.5rem;"></span>
        <div class="navbar-nav ms-3 align-items-center">
            <a class="nav-link text-black mx-2" href="#" style="transition: color 0.3s, transform 0.2s;">
                <i class="bi bi-bell" style="font-size: 1.2rem;"></i>
            </a>
            <li class="nav-item dropdown mx-2">
                <a class="nav-link text-black position-relative" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-chat" style="font-size: 1.4rem;"></i>
                    <?php if (!empty($userList)) { ?>
                        <span class="position-absolute top-1 start-100 translate-middle badge rounded-pill bg-danger">
                            <?= count($userList) ?>
                        </span>
                    <?php } ?>
                </a>

                <ul class="dropdown-menu dropdown-menu-end shadow p-2" style="width: 280px; max-height: 350px; overflow-y: auto; background-color: #ffffff; border: 1px solid #dee2e6; border-radius: 10px;">
                    <li>
                        <h6 class="dropdown-header text-primary fw-bold">💬 Tin nhắn đến</h6>
                    </li>
                    <?php if (!empty($userList)) { ?>
                        <?php foreach ($userList as $user) { ?>
                            <li>
                                <a class="dropdown-item d-flex align-items-center py-2 px-3" href="?chat_user_id=<?= htmlspecialchars($user) ?>">
                                    <i class="bi bi-person-circle text-success me-2" style="font-size: 1.2rem;"></i>
                                    <span>Người dùng: <?= $userController->getById($user)['FullName'] ?? "Không có tên"  ?></span>
                                </a>
                            </li>
                        <?php } ?>
                    <?php } else { ?>
                        <li>
                            <span class="dropdown-item fst-italic">Không có tin nhắn nào</span>
                        </li>
                    <?php } ?>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item text-end text-danger" href="Admin.php"><i class="bi bi-box-arrow-left me-1"></i>Đóng</a></li>
                </ul>
            </li>
            <a class="nav-link text-black mx-2" href="Admin.php?page=modules/Admin/Profile/index.php" style="transition: color 0.3s, transform 0.2s;">
                <i class="bi bi-person" style="font-size: 1.2rem;"></i>
            </a>
        </div>
    </div>
</nav>
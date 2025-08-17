<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập Hệ Thống</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../Style/Admin/Login.css">
</head>

<body class="gradient-bg min-h-screen flex items-center justify-center p-4">
    <div class="login-box bg-white rounded-xl p-8 w-full max-w-md">
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-user-shield text-indigo-500 text-3xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-800">ĐĂNG NHẬP HỆ THỐNG</h1>
            <p class="text-gray-600 mt-2">Vui lòng nhập thông tin đăng nhập</p>
        </div>

        <form id="loginForm" method="post" class="space-y-6" action="/Admin.php">
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Email đăng nhập</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user text-gray-400"></i>
                    </div>
                    <input type="email" id="username" name="email"
                        class="input-field pl-10 w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-200"
                        placeholder="Nhập email đăng nhập" required>
                </div>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mật khẩu</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-gray-400"></i>
                    </div>
                    <input type="password" id="password" name="password"
                        class="input-field pl-10 w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-200"
                        placeholder="Nhập mật khẩu" required>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer" onclick="togglePasswordVisibility()">
                        <i id="togglePasswordIcon" class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                    </div>
                </div>
            </div>

            <!-- <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input type="checkbox" id="remember" name="remember"
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                    <label for="remember" class="ml-2 block text-sm text-gray-700">Ghi nhớ đăng nhập</label>
                </div>
                <a href="#" class="text-sm text-indigo-600 hover:text-indigo-500">Quên mật khẩu?</a>
            </div> -->

            <div class="flex items-center">
                <span class="text-sm text-gray-700 mr-3">Đăng nhập với tư cách:</span>
                <div class="relative inline-block w-10 mr-2 align-middle select-none">
                    <input type="checkbox" id="isAdmin" name="isAdmin"
                        class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer" />
                    <label for="isAdmin" class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                </div>
                <label for="isAdmin" class="text-sm font-medium text-gray-700">Admin</label>
            </div>

            <button type="submit"
                name="login"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-lg transition duration-200 flex items-center justify-center">
                <i class="fas fa-sign-in-alt mr-2"></i> Đăng nhập
            </button>
        </form>
    </div>
    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const icon = document.getElementById('togglePasswordIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>

</html>
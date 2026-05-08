<?php
session_start();

// Thông tin tài khoản mặc định
$valid_user = "admin";
$valid_password = "password123";
$valid_password = "123";


// Kiểm tra xem user đã đăng nhập chưa (còn hiệu lực session)
if (isset($_SESSION['user_logged_in'])) {
    header("Location: baitap07-02(luucooki).php");
    exit();
} 
// Nếu chưa có session, kiểm tra xem có cookie "ghi nhớ" không
elseif (isset($_COOKIE["remember_user"]) && $_COOKIE["remember_user"] == $valid_user) {
    // Gán lại session bằng thông tin đã lưu trong cookie
    $_SESSION['user_logged_in'] = $_COOKIE["remember_user"];
    header("Location: baitap07-02(luucooki).php");
    exit();
}

$error = "";

// Kiểm tra khi nhấn nút Đăng nhập
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];
    $remember = isset($_POST['remember']) ? true : false;

    if ($user === $valid_user && $pass === $valid_password) {
        $_SESSION['user_logged_in'] = $user;

        if ($remember) {
            // Lưu cookie trong 30 ngày (86400 * 30)
            setcookie('remember_user', $user, time() + (86400 * 30));
        }

        header("Location: baitap07-02(luucooki).php");
        exit();
    } else {
        echo "<script>alert('Sai tài khoản hoặc mật khẩu!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập hệ thống</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        body { background-color: #f8f9fa; height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-card { max-width: 400px; width: 100%; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); background: #fff; }
    </style>
</head>
<body>

<div class="login-card">
    <h3 class="text-center mb-4 text-primary">Đăng Nhập Hệ Thống</h3>
    <form action="" method="POST">
        <div class="input-group mb-3">
            <span class="input-group-text">👤</span>
            <input type="text" name="username" class="form-control" placeholder="Tên đăng nhập" required>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text">🔒</span>
            <input type="password" name="password" class="form-control" placeholder="Mật khẩu" required>
        </div>
        <div class="form-check mb-3">
            <!-- Thêm name="remember" để PHP có thể nhận giá trị -->
            <input type="checkbox" class="form-check-input" id="remember" name="remember">
            <label class="form-check-label" for="remember">Nhớ mật khẩu</label>
        </div>
        <button type="submit" name="login" class="btn btn-primary w-100 fw-bold">Đăng nhập</button>
    </form>
</div>

</body>
</html>
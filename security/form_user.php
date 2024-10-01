<?php
// Bắt đầu phiên
session_start();
require_once 'models/UserModel.php';
$userModel = new UserModel();

// Mã hóa và giải mã
function encrypt($data, $key) {
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
    return base64_encode($encrypted . '::' . $iv);
}

function decrypt($data, $key) {
    list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
    return openssl_decrypt($encrypted_data, 'aes-256-cbc', $key, 0, $iv);
}

$key = 'your_secret_key'; // Thay đổi giá trị này

$user = NULL; // Thêm người dùng mới
$_id = NULL;

$errors = [];

// Kiểm tra nếu có ID trong URL
if (!empty($_GET['id'])) {
    // Giải mã user ID từ URL
    $_id = decrypt($_GET['id'], $key);
    $user = $userModel->findUserById($_id); // Cập nhật người dùng hiện có
}

// Xử lý khi form được gửi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu từ form
    $name = trim($_POST['name']);
    $password = trim($_POST['password']);

    // Xác thực tên
    if (empty($name)) {
        $errors[] = "Tên là bắt buộc.";
    } elseif (!preg_match("/^[a-zA-Z0-9]{5,15}$/", $name)) {
        $errors[] = "Tên phải từ 5 đến 15 ký tự và chỉ chứa chữ cái và số.";
    }

    // Xác thực mật khẩu
    if (empty($password)) {
        $errors[] = "Mật khẩu là bắt buộc.";
    } elseif (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[~!@#$%^&*()])[A-Za-z\d~!@#$%^&*()]{5,10}$/", $password)) {
        $errors[] = "Mật khẩu phải từ 5 đến 10 ký tự, bao gồm ít nhất một chữ thường, một chữ hoa, một số và một ký tự đặc biệt (~!@#$%^&*()).";
    }

    // Nếu không có lỗi, xử lý form
    if (empty($errors)) {
        if (!empty($_id)) {
            $userModel->updateUser($_POST);
        } else {
            $userModel->insertUser($_POST);
        }
        header('Location: list_users.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Form Người Dùng</title>
    <?php include 'views/meta.php'; ?>
</head>

<body>
    <?php include 'views/header.php'; ?>
    <div class="container">
        <?php if ($user || !isset($_id)) { ?>
            <div class="alert alert-warning" role="alert">
                Form Người Dùng
            </div>

            <!-- Hiển thị lỗi -->
            <?php if (!empty($errors)) { ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach ($errors as $error) { ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>

            <form method="POST">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($_id); ?>">
                <div class="form-group">
                    <label for="name">Tên</label>
                    <input class="form-control" name="name" placeholder="Tên"
                           value="<?php echo isset($user['name']) ? htmlspecialchars($user['name']) : ''; ?>">
                </div>
                <div class="form-group">
                    <label for="password">Mật khẩu</label>
                    <input type="password" name="password" class="form-control" placeholder="Mật khẩu">
                </div>

                <button type="submit" name="submit" class="btn btn-primary">Gửi</button>
            </form>
        <?php } else { ?>
            <div class="alert alert-success" role="alert">
                Người dùng không tìm thấy!
            </div>
        <?php } ?>
    </div>
</body>

</html>

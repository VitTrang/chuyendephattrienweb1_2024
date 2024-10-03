<?php
// Start the session
session_start();
require_once 'models/UserModel.php';
$userModel = new UserModel();

// Mã hóa và giải mã
function encrypt($data, $key) {
    $iv = openssl_random_pseudo_bytes(16); // Tạo IV 16 bytes chính xác
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
    return base64_encode($encrypted . '::' . $iv);
}

function decrypt($data, $key) {
    list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
    if (strlen($iv) !== 16) {
        return false; // Kiểm tra chiều dài IV
    }
    return openssl_decrypt($encrypted_data, 'aes-256-cbc', $key, 0, $iv);
}

$key = 'your_secret_key'; // Thay đổi giá trị này

$user = NULL; // Add new user
$_id = NULL;

$errors = [];

if (!empty($_GET['id'])) {
    // Giải mã user ID từ URL
    $_id = decrypt($_GET['id'], $key);
    if ($_id === false) {
        $errors[] = "ID không hợp lệ.";
    } else {
        $user = $userModel->findUserById($_id); // Update existing user
    }
}

if (!empty($_POST['submit'])) {
    // Validation
    $name = $_POST['name'];
    $password = $_POST['password'];

    // Name validation
    if (empty($name)) {
        $errors[] = "Tên là bắt buộc.";
    } elseif (!preg_match("/^[a-zA-Z0-9]{5,15}$/", $name)) {
        $errors[] = "Tên phải từ 5 đến 15 ký tự";
    }

    // Password validation
    if (empty($password)) {
        $errors[] = "Mật khẩu là bắt buộc.";
    } elseif (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[~!@#$%^&*()])[A-Za-z\d~!@#$%^&*()]{5,10}$/", $password)) {
        $errors[] = "Mật khẩu phải từ 5 đến 10 ký tự, bao gồm ít nhất một chữ thường, một chữ hoa, một số và một ký tự đặc biệt (~!@#$%^&*()).";
    }

    // If no errors, process the form
    if (empty($errors)) {
        if (!empty($_id)) {
            $userModel->updateUser($_POST);
        } else {
            $userModel->insertUser($_POST);
        }
        header('location: list_users.php');
        exit;
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>User form</title>
    <?php include 'views/meta.php' ?>
</head>
<body>
    <?php include 'views/header.php'?>
    <div class="container">
        <?php if (!empty($user) || empty($_id)) { ?>
            <div class="alert alert-warning" role="alert">
                User form
            </div>

            <!-- Display Errors -->
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
                <input type="hidden" name="id" value="<?php echo htmlspecialchars(encrypt($_id, $key)); ?>">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input class="form-control" name="name" placeholder="Name" value='<?php if (!empty($user['name'])) echo htmlspecialchars($user['name']); ?>'>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Password">
                </div>

                <button type="submit" name="submit" value="submit" class="btn btn-primary">Submit</button>
            </form>
        <?php } else { ?>
            <div class="alert alert-success" role="alert">
                User not found!
            </div>
        <?php } ?>
    </div>
</body>
</html>

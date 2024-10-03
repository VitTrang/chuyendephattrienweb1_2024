<?php
session_start();
require_once 'models/UserModel.php';
$userModel = new UserModel();

if (!empty($_GET['id'])) {
    $id = $_GET['id'];
    if ($_SESSION['id'] == $id) {
        $userModel->deleteUserById($id); // Xóa người dùng hiện tại
        $_SESSION['message'] = 'Người dùng đã được xóa thành công.';
    } else {
        $_SESSION['message'] = 'Bạn không có quyền thực hiện hành động này.';
    }
}
header('location: list_users.php');
?>

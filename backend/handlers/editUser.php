<?php
include_once './backend/core/userController.php';


if (isset($_SESSION['user'])) {
    $uc = new userController();
    unset($_SESSION['profile_error']);
    $user = $_SESSION['user'];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_POST['name'])) {
            $_SESSION['profile_error'] = "Please fill in all fields.";
            header('Location: /profile');
            exit();
        }
        if (empty(trim($_POST['name']))) {
            $_SESSION['profile_error'] = "Please fill in all fields.";
            header('Location: /profile');
            exit();
        }
        $uc->editUser($_POST['name'], $user['id']);
        $_SESSION['user']['name'] = $_POST['name'];
        header('Location: /profile');
        exit();
    }
    header('Location: /profile');
} else {
    header("Location: /");
    exit;
}



?>
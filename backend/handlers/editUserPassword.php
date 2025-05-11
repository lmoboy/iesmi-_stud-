<?php
include_once './backend/core/userController.php';


if (isset($_SESSION['user'])) {
    $uc = new userController();
    unset($_SESSION['profile_error']);
    $user = $_SESSION['user'];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_POST['old-password'])) {
            $_SESSION['profile_error'] = "Please fill in all fields.";
            header('Location: /profile#security');
            exit();
        }
        if (empty(trim($_POST['new-password']))) {
            $_SESSION['profile_error'] = "Please fill in all fields.";
            header('Location: /profile#security');
            exit();
        }
        if($uc->checkPassword($_POST['old-password'], $user['id'])){
            $_SESSION['profile_error'] = "Wrong password.";
            header('Location: /profile#security');
            exit();
        }
        $uc->editUserPassword($_POST['new-password'], $user['id']);
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
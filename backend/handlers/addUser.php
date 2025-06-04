<?php
include_once './backend/core/userController.php';


if (isset($_SESSION['user'])) {
    $uc = new userController();
    unset($_SESSION['addUser_error']);
    $user = $_SESSION['user'];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_POST['role'])) {
            $_SESSION['addUser_error'] = "Please fill in all fields.";
            header('Location: /add-user');
            exit();
        }
        if (empty(trim($_POST['name']))) {
            $_SESSION['addUser_error'] = "Please fill in all fields.";
            header('Location: /add-user');
            exit();
        }
        if (empty(trim($_POST['password']))) {
            $_SESSION['addUser_error'] = "Please fill in all fields.";
            header('Location: /add-user');
            exit();
        }
        if (strlen(string: trim($_POST['password'])) < 8) {
            $_SESSION['addUser_error'] = "Make sure the password is atleast 8 characters long.";
            header('Location: /add-user');
            exit();
        }
        if($uc->checkIfUserExisst($_POST['name'])){
            $_SESSION['addUser_error'] = "User already exists.";
            header('Location: /add-user');
            exit();
        }
        $resualt = $uc->createUser($_POST['name'], password_hash($_POST['password'], PASSWORD_DEFAULT), $_POST['role']);
        header('Location: /add-user');
        exit();
    }
    header('Location: /add-user');
} else {
    header("Location: /");
    exit;
}



?>
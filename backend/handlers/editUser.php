<?php
include_once './backend/core/userController.php';



// <img id="profile-picture-preview" src="/backend/files/<?=$_SESSION['user']['profile_picture']\?\>.jpg"
//     class="w-full rounded-full" />

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

        if (isset($_FILES['profile-picture'])) {
            if ($_FILES['profile-picture']['error'] === UPLOAD_ERR_OK) {
                var_dump($_FILES['profile-picture']);
                $targetDir = './backend/files/';
                $targetFile = $targetDir . basename($_FILES['profile-picture']['name']);
                move_uploaded_file($_FILES['profile-picture']['tmp_name'], $targetFile);
                $_SESSION['user']['profile_picture'] = $_FILES['profile-picture']['name'];
                $uc->updateUserImage($_SESSION['user']['id'], $_SESSION['user']['profile_picture']);
            } else {
                $_SESSION['profile_error'] = "File upload error: " . $_FILES['profile-picture']['error'];
            }
        } else {
            $_SESSION['profile_error'] = "No file uploaded.";
        }


    }



    // header('Location: /profile');
} else {
    // header("Location: /");
    exit;
}



?>
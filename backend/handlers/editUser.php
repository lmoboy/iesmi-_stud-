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


        if (isset($_FILES['profile-picture']) && $_FILES['profile-picture']['error'] === UPLOAD_ERR_OK) {
            $result = $uc->updateUserImage($user['id'], $_FILES['profile-picture']);
            if ($result) {
                $_SESSION['user']['profile_picture'] = $result;
            } else {
                $_SESSION['profile_error'] = "Failed to upload profile picture.";
            }
        }

        header('Location: /profile');
        exit();
    }
    header('Location: /profile');
} else {
    header("Location: /");
    exit;
}



?>
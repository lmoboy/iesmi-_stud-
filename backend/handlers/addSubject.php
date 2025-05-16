<?php
include_once './backend/core/subjectController.php';
include_once './backend/core/userController.php';


if (isset($_SESSION['user'])) {
    $uc = new userController();
    $sc = new subjectController();
    unset($_SESSION['addSubject_error']);
    $user = $_SESSION['user'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if (empty(trim($_POST['subject']))) {
            $_SESSION['addSubject_error'] = "Please fill in all fields.";
            header('Location: /add-subject');
            exit();
        }

        $sc->createSubject(trim($_POST['subject']));
        header('Location: /add-subject');
        exit();
    }
    header('Location: /add-subject');
} else {
    header("Location: /");
    exit;
}



?>
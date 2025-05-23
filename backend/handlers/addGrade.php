<?php
include_once './backend/core/gradeController.php';
include_once './backend/core/userController.php';


if (isset($_SESSION['user'])) {
    $gc = new gradeController();
    $sc = new subjectController();
    unset($_SESSION['addGrade_error']);
    $user = $_SESSION['user'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // if (empty(trim($_POST['subject']))) {
        //     $_SESSION['addGrade_error'] = "Please fill in all fields.";
        //     header('Location: /add-subject');
        //     exit();
        // }

        $sc->createSubject(trim($_POST['subject']));
        header('Location: /add-grade');
        exit();
    }
    header('Location: /add-grade');
} else {
    header("Location: /");
    exit;
}



?>
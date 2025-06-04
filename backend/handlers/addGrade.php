<?php
include_once './backend/core/gradeController.php';
include_once './backend/core/userController.php';
include_once './backend/core/subjectController.php';


if (isset($_SESSION['user'])) {
    $gc = new gradeController();
    $sc = new subjectController();
    unset($_SESSION['addGrade_error']);
    $user = $_SESSION['user'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if (empty(trim($_POST['student_id']))) {
            $_SESSION['addGrade_error'] = "Please fill in all fields.";
            header('Location: /add-grade');
            exit();
        }

        if (empty(trim($_POST['subject_id']))) {
            $_SESSION['addGrade_error'] = "Please fill in all fields.";
            header('Location: /add-grade');
            exit();
        }

        if (empty(trim($_POST['grade']))) {
            $_SESSION['addGrade_error'] = "Please fill in all fields.";
            header('Location: /add-grade');
            exit();
        }

        if (trim($_POST['grade']) < 0 || trim($_POST['grade']) > 10) {
            $_SESSION['addGrade_error'] = "Make sure the grade is between 0 and 10.";
            header('Location: /add-grade');
            exit();
        }

        $gc->addGrades(trim($_POST['student_id']), trim($_POST['subject_id']), trim($_POST['grade']));
        header('Location: /admin#grades');
        exit();
    }
    header('Location: /add-grade');
} else {
    header("Location: /");
    exit;
}



?>
<?php

include_once './backend/core/gradeController.php';
include_once './backend/core/subjectController.php';


if (isset($_SESSION['user'])) {
    $gc = new gradeController();
    $sc = new subjectController();
    unset($_SESSION['editGrade_error']);
    $user = $_SESSION['user'];


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if (!isset($_POST['grade']) || !isset($_POST['subject'])) {
            $_SESSION['editGrade_error'] = "Please fill in all fields.";
            header('Location: /edit-grade?id=' . $_POST['grade_id']);
            exit();
        }

        if ($_POST['grade'] < 0 || $_POST['grade'] > 100) {
            $_SESSION['editGrade_error'] = "Grade must be between 0 and 100.";
            header('Location: /edit-grade?id=' . $_POST['grade_id']);
            exit();
        }

        if ($gc->updateGrade($_POST["grade_id"], $_POST["grade"], $_POST['subject']) == false) {
            $_SESSION['editGrade_error'] = "Failed to update grade.";
        }else{
        // $_SESSION['editGrade_error'] = "Grade updated successfully.";
        header('Location: /admin#grades');
        exit();
        }

    }
    header('Location: /edit-grade?id=' . $_POST['grade_id']);
} else {
    header("Location: /");
    exit;
}



?>
<?php

require_once './backend/core/gradeController.php';
require_once './backend/core/userController.php';
require_once './backend/core/subjectController.php';

if(!isset($_SESSION["user"])){
    if ($_SESSION["user"]["role"] != "admin") {
        header("Location: /");
    } else if ($_SESSION["user"]["role"] != "teacher") {
        header("Location: /");
    }else{

    }
    
    header("Location: /");
    exit;
}
$subjects = ((new subjectController)->getSubjects());
// var_dump($grade);
// echo "<br/>";
// var_dump($subjects);
// echo "<br/>";
// var_dump((new SubjectController)->getSubjectsByName('history'));
?>

<main class="p-4 min-h-screen">
    <div class="space-y-4">
        <h2 class="text-xl font-bold text-center">Edit Grades</h2>
        <form method="POST" action="/backend/addSubject" class="space-y-4">
            <div class="form-control">
                <label class="label" for="subject">
                    <span class="label-text">Subject name</span>
                </label>
                <input type="text" id="subject" name="subject" required class="input input-bordered w-full"/>
            </div>
            <div class="flex justify-center">
                <?php if (isset($_SESSION['addSubject_error'])): ?>
                    <div class="alert alert-error mb-4"><?= $_SESSION['addSubject_error'] ?></div>
                    <?php unset($_SESSION['addSubject_error']); ?>
                <?php endif; ?>
                <button type="submit" class="btn btn-primary">Add Subject</button>
            </div>
        </form>
    </div>
</main>




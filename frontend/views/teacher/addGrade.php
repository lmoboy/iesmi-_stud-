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
$gc = new gradeController;
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
        <form method="POST" action="/backend/addGrade" class="space-y-4">
                        <div class="form-control">
                <label class="label" for="grade">
                    <span class="label-text">Student</span>
                </label>
                <input type="text" id="student" name="student" required class="input input-bordered w-full" />
            </div>
            <div class="form-control">
                <label class="label" for="grade">
                    <span class="label-text">Grade</span>
                </label>
                <input type="number" id="grade" name="grade" required class="input input-bordered w-full" min="0" max="100" />
            </div>
            <div class="form-control">
                <label class="label" for="subject">
                    <span class="label-text">Subject</span>
                </label>
                <select id="subject" name="subject" required class="select select-bordered w-full">
                    <?php foreach ($subjects as $subject): ?>
                        <option value="<?= $subject['id'] ?>">
                            <?= htmlspecialchars($subject['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="flex justify-center">
                <?php if (isset($_SESSION['addGrade_error'])): ?>
                    <div class="alert alert-error mb-4"><?= $_SESSION['addGrade_error'] ?></div>
                    <?php unset($_SESSION['addGrade_error']); ?>
                <?php endif; ?>
                <button type="submit" class="btn btn-primary">Add Grade</button>
            </div>
        </form>
    </div>
</main>

<script>

</script>
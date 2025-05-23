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
$uc = new userController();
$users = $uc->getUsers();
?>

<main class="p-4 min-h-screen">
    <div class="space-y-4">
        <h2 class="text-xl font-bold text-center">Add Grades</h2>
        <form method="POST" action="/backend/addGrade" class="space-y-4">
                        <div class="form-control">
                <label class="label" for="student_id">
                    <span class="label-text">Student</span>
                </label>
                <select id="student_id" name="student_id" required class="select select-bordered w-full">
                    <?php foreach ($users as $user): ?>
                        <option value="<?= htmlspecialchars($user['id']) ?>">
                            <?= htmlspecialchars($user['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-control">
                <label class="label" for="grade">
                    <span class="label-text">Grade</span>
                </label>
                <input type="number" id="grade" name="grade" required class="input input-bordered w-full" min="1" max="10" />
            </div>
            <div class="form-control">
                <label class="label" for="subject_id">
                    <span class="label-text">Subject</span>
                </label>
                <select id="subject_id" name="subject_id" required class="select select-bordered w-full">
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
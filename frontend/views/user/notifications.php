<?php
require_once './backend/core/gradeController.php';
$gc = new gradeController();
$grades = $gc->getUserGrades($_SESSION['user']['id']);
$notifications;
foreach ($grades as $grade) {
    if ($grade['notified'] == 1) {
        $notifications[] = $grade;
        $gc->setGradeRead($grade['id']);
    }
}





View::partial("Head");
View::partial("Navbar");




?>

<?php foreach ($notifications as $notification): ?>

    <p>
        grade <?= $notification["grade"] ?>     <?= $notification["created_at"] ?>     <?= $notification["teacher_id"] ?>
    </p>


<?php endforeach; ?>



<?php

View::partial("Footer");

?>
<?php
if (!isset($_SESSION["user"])) {
    exit("");
}
require_once './backend/core/gradeController.php';
$gc = new gradeController();
$grades = $gc->getUserGrades($_SESSION['user']['id']);
$notifications = [];
// echo '<pre>';
foreach ($grades as $grade) {
    if ($grade['notified'] == 1) {
        $formattedGrade = $gc->getGradesFormatted($grade['id'])[0];
        $formattedGrade['created_at'] = $grade["created_at"];
        // var_dump($formattedGrade);
        $notifications[] = $formattedGrade;
        $gc->setGradeRead($grade['id']);
    }
}
// echo '</pre>';

// usort($notifications, function ($a, $b) {
//     return strtotime($b['created_at']) - strtotime($a['created_at']);
// });



// var_dump($notifications);



View::partial("Head");
View::partial("Navbar");




?>
<table>
    <thead>
        <tr>
            <th>Grade</th>
            <th>Subject</th>
            <th>Teacher</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($notifications as $notification): ?>
            <tr>
                <td style="text-align: center"><?= $notification["grade"] ?></td>
                <td style="text-align: center"><?= $notification["subject"] ?></td>
                <td style="text-align: center"><?= $notification["teacher"] ?></td>
                <td style="text-align: center"><?= $notification['created_at'] ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>



<?php

View::partial("Footer");

?>
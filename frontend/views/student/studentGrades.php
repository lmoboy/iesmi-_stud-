<?php
require_once './backend/core/gradeController.php';
require_once './backend/core/subjectController.php';

$gradeController = new gradeController();
$subjectController = new subjectController();
$user = $data['user_id'] ?? $_SESSION['user']['id'];
$grades = $gradeController->getUserGrades($user);
$subjects = $subjectController->getSubjects();


?>
<table class="table w-full">
    <thead>
        <tr>
            <th>Details</th>
            <th>Subject</th>
            <th>Average Grade</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($subjects as $subject): ?>
            <tr>
                <td><a href="subject?id=<?=$subject['id'] ?><?= $user ? "&?user_id=".$user : ''?>" class="btn btn-primary">Detailed</a></td>
                <td><?= $subject['name'] ?></td>
                <td>
                    <?php
                    $totalGrade = 0;
                    $gradeCount = 0;
                    foreach ($grades as $grade) {
                        if ($grade['subject_id'] == $subject['id']) {
                            $totalGrade += $grade['grade'];
                            $gradeCount++;
                        }
                    }
                    if ($gradeCount > 0) {
                        echo round($totalGrade / $gradeCount, 2);
                    } else {
                        echo '-';
                    }
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

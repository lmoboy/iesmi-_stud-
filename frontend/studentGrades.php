<?php
require_once './backend/core/gradeController.php';
require_once './backend/core/subjectController.php';

$gradeController = new gradeController();
$subjectController = new subjectController();


$grades = $gradeController->getUserGrades($_SESSION['user']['id']);
$subjects = $subjectController->getSubjects();



?>
<table class="table w-full">
    <thead>
        <tr>
            <th>Subject</th>
            <th>Grade</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($subjects as $subject): ?>
            <tr>
                <td><?= $subject['name'] ?></td>
                <td>
                    <?php
                    $found = false;
                    foreach ($grades as $grade) {
                        if ($grade['subject_id'] == $subject['id']) {
                            echo $grade['grade'];
                            $found = true;
                            break;
                        }
                    }
                    if (!$found) {
                        echo '-';
                    }
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

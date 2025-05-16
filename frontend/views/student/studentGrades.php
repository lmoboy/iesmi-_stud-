<?php
require_once './backend/core/gradeController.php';
require_once './backend/core/subjectController.php';

$gradeController = new gradeController();
$subjectController = new subjectController();
$user = $data['user_id'] ?? $_SESSION['user']['id'];
$grades = $gradeController->getUserGrades($user);
$subjects = $subjectController->getSubjects();


?>
<main class="min-h-screen">
    <table class="table w-full">
        <div class="mt-6">
            <a href="/export?id=<?= $user ?>" class="btn btn-secondary">Export Data</a>
        </div>
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
                    <td><a href="subject?id=<?= $subject['id'] ?><?= $user ? "&user_id=" . $user : '' ?>"
                            class="btn btn-primary">Detailed</a></td>
                    <td><?= htmlspecialchars($subject['name']) ?></td>
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
</main>
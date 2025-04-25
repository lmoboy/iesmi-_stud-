<?php

require_once './backend/core/gradeController.php';
require_once './backend/core/subjectController.php';
$targetSubjectID = $data['id'] ?? header("Location: /grades");
$gc = new gradeController;
$sc = new subjectController;
$grades = $gc->getGrades();
$subject = $sc->getSubjects()[$targetSubjectID - 1];

function getDateForDatabase($date)
{
    $timestamp = strtotime($date);
    $date_formated = date('M', $timestamp);
    return $date_formated;
}


$grades = array_filter($grades, function ($grade) use ($targetSubjectID) {
    return $grade['subject_id'] == $targetSubjectID && $grade['user_id'] == $_SESSION['user']['id'];
});

$dates = array_unique(array_map(function ($grade) {
    return getDateForDatabase($grade['created_at']);
}, $grades));

usort($dates, function ($a, $b) {
    return strtotime($a) - strtotime($b);
});



?>
<main>
    <div>
        <h1 style="text-align: center; font-size: 2em; font-weight: bold;">Subject Grades</h1>
        <h2 style="text-align: center; font-size: 1.5em;"><?= htmlspecialchars($subject['name']) ?></h2>
    </div>
    <div class="overflow-x-auto">
        <table class="table w-full">
            <thead>
                <tr>
                    <?php foreach ($dates as $date): ?>
                        <th><?= htmlspecialchars($date) ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($grades as $grade): ?>
                    <tr>
                        <?php foreach ($dates as $date): ?>
                            <?php if (getDateForDatabase($grade['created_at']) == $date): ?>
                                <td><?= htmlspecialchars($grade['grade']) ?></td>
                                <?php if ($_SESSION['user']['role'] == 'admin' || $_SESSION['user']['role'] == 'teacher'): ?>
                                    <td><a href="/edit-grade?id=<?= $grade['id'] ?>" class="btn btn-primary">Edit</a></td>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>
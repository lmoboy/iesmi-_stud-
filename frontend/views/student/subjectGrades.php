<?php

require_once './backend/core/gradeController.php';
require_once './backend/core/subjectController.php';
$targetSubjectID = $data['id'] ?? header("Location: /grades");
$userID = $data["user_id"] ?? $_SESSION['user']['id'];
$gc = new gradeController;
$sc = new subjectController;
$grades = $gc->getUserGrades($userID);
$subject = $sc->getSubjects()[$targetSubjectID - 1];

function getDateForDatabase($date)
{
    $timestamp = strtotime($date);
    $date_formated = date('M', $timestamp);
    return $date_formated;
}

$grades = array_filter($grades, function ($grade) use ($targetSubjectID) {
    return $grade['subject_id'] == $targetSubjectID;
});

$dates = array_unique(array_map(function ($grade) {
    return getDateForDatabase($grade['created_at']);
}, $grades));

usort($dates, function ($a, $b) {
    return strtotime($a) - strtotime($b);
});



echo "<pre>";
// var_dump($grades);
echo "</pre>";


?>
<main>
    <div>
        <h1 style="text-align: center; font-size: 2em; font-weight: bold;">Subject Grades</h1>
        <h2 style="text-align: center; font-size: 1.5em;"><?= htmlspecialchars(ucfirst($subject['name'])) ?></h2>
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
                <tr class="border border-gray-300">
                    <?php foreach ($dates as $date): ?>
                        <td class="border border-gray-300">
                            <?php foreach ($grades as $grade): ?>
                                <?php if (getDateForDatabase($grade['created_at']) == $date): ?>
                                    <?= htmlspecialchars($grade['grade']) ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </td>
                    <?php endforeach; ?>
                </tr>
            </tbody>
        </table>
    </div>
</main>
<!-- 
<?php if ($_SESSION['user']['role'] == 'admin' || $_SESSION['user']['role'] == 'teacher'): ?>
                                    <td><a href="/edit-grade?id=<?= $grade['id'] ?>" class="btn btn-primary">Edit</a></td>
                                <?php endif; ?> -->
<?php

require_once './backend/core/gradeController.php';
require_once './backend/core/userController.php';
require_once './backend/core/subjectController.php';

$uc = new userController;
$gc = new gradeController;
$sc = new subjectController;

$user = $data['user_id'] ?? $_SESSION['user']['id'];

$grade = $gc->getGradeById($data['id'])[0];
$user = $uc->getUser($user)[0];
$teacher = $uc->getUser($grade['teacher_id'])[0];
$subject = $sc->getSubjectById($grade['subject_id'])[0];

?>

<main class="p-6 bg-gray-100">
    <div class="max-w-md mx-auto bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Grade Details</h2>
        <p><strong>Teacher:</strong> <?= htmlspecialchars($teacher['name']) ?></p>
        <p><strong>Student:</strong> <?= htmlspecialchars($user['name']) ?></p>
        <p><strong>Subject:</strong> <?= htmlspecialchars($subject['name']) ?></p>
        <p><strong>Issued:</strong> <?= htmlspecialchars($grade['created_at']) ?></p>
        <p><strong>Grade:</strong> <?= htmlspecialchars($grade['grade']) ?></p>

        <?php if (SimpleMiddleWare::validRole('teacher, admin')): ?>
            <div class="mt-6 flex space-x-4">
                <a href="edit-grade?id=<?= urlencode($grade['id']) ?>" class="btn btn-primary">Edit Grade</a>
                <a href="delete-grade?id=<?= urlencode($grade['id']) ?>" class="btn btn-error">Remove Grade</a>
            </div>
        <?php endif; ?>
    </div>
</main>
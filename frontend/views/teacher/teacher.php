<?php

require_once './backend/core/gradeController.php';
require_once './backend/core/userController.php';
require_once './backend/core/subjectController.php';

if(!isset($_SESSION["user"]) || $_SESSION["user"]["role"] != "teacher") {
    header("Location: /");
    exit;
}
$uc = new userController;
$users = $uc->getUsers();
?>




<main class="p-4 min-h-screen">
    <div class="overflow-x-auto">
        <div class="flex justify-end"><a href="/add-subject" class="btn btn-primary">Add Subject</a></div>
        <div class="flex justify-end"><a href="/add-grade" class="btn btn-primary">Add Grade</a></div>
        <table class="table w-full">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Grades</th>
                </tr>
            </thead>
            <tbody id="user-list">
                <?php foreach ($users as $index => $user): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= htmlspecialchars($user['name']) ?></td>
                        <td><a href="/grades?user_id=<?= $user['id'] ?>" class="btn btn-primary">View Grades</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

<script>

</script>
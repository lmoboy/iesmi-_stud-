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




<main class="p-4">
    <div class="overflow-x-auto">
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
    <div class="flex justify-center mt-4">
        <div class="btn-group" id="pagination">
            <button class="btn">Previous</button>
            <button class="btn">1</button>
            <button class="btn">2</button>
            <button class="btn">3</button>
            <button class="btn">Next</button>
        </div>
    </div>
</main>

<script>

</script>
<?php

require_once './backend/core/gradeController.php';
require_once './backend/core/userController.php';
require_once './backend/core/subjectController.php';

$uc = new userController;
$gc = new gradeController;
$sc = new subjectController;

$users = $uc->getUsers();
$grades = $gc->getGradesFormatted();
$subjects = $sc->getSubjects();

?>




<body>
    <div class="p-4 space-y-4">
        <h1 class="text-3xl font-bold text-center text-primary">Admin Panel</h1>
        <div class="tabs">
            <a class="tab tab-lg tab-bordered tab-active" href="#users">Users</a>
            <a class="tab tab-lg tab-bordered" href="#grades">Grades</a>
            <a class="tab tab-lg tab-bordered" href="#subjects">Subjects</a>
        </div>
        <div id="users" class="tabs what p-4">
            <table class="table p-4">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= $user['id'] ?></td>
                            <td><?= htmlspecialchars($user['name']) ?></td>
                            <td><?= $user['role'] ?></td>
                            <td>
                                <a href="/grades?user_id=<?= $user['id'] ?>" class="btn btn-primary btn-sm">View grades</a>
                                <a href="/edit-user?id=<?= $user['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                                <a href="/delete-user?id=<?= $user['id'] ?>" class="btn btn-error btn-sm">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <a href="/add-user" class="btn btn-primary">Add User</a>
        </div>
        <div id="grades" class="tabs what p-4 hidden">
            <table class="table p-4">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Teacher</th>
                        <th>Subject</th>
                        <th>Grade</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($grades as $grade): ?>
                        <tr>
                            <td><?= htmlspecialchars($grade["user"]) ?></td>
                            <td><?= htmlspecialchars($grade["teacher"]) ?></td>
                            <td><?= htmlspecialchars($grade["subject"])  ?></td>
                            <td><?= $grade["grade"] ?></td>
                            <td>
                                <a href="/edit-grade?id=<?= $grade["id"] ?>" class="btn btn-primary btn-sm">Edit</a>
                                <a href="/delete-grade?id=<?= $grade["id"] ?>" class="btn btn-error btn-sm">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <a href="/add-grade" class="btn btn-primary">Add Grade</a>
        </div>
        <div id="subjects" class="tabs what p-4 hidden">
            <table class="table p-4">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($subjects as $subject): ?>
                        <tr>
                            <td><?= $subject["id"] ?></td>
                            <td><?= htmlspecialchars($subject["name"]) ?></td>
                            <td>
                                <a href="/edit-subject?id=<?= $subject["id"] ?>" class="btn btn-primary btn-sm">Edit</a>
                                <a href="/delete-subject?id=<?= $subject["id"] ?>" class="btn btn-error btn-sm">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <a href="/add-subject" class="btn btn-primary">Add Subject</a>
        </div>
    </div>
    <script>
        const tabs = document.querySelectorAll('.tab');
        const tabContents = document.querySelectorAll('.tabs.what');

        tabs.forEach(tab => {
            tab.addEventListener('click', function () {
                const id = this.getAttribute('href');
                tab.classList.add('tab-active');
                tabs.forEach(tab => {
                    if (tab.getAttribute('href') !== id) {
                        tab.classList.remove('tab-active');
                    }
                });
                tabContents.forEach(tabContent => {
                    if (tabContent.id === id.substring(1)) {
                        tabContent.classList.remove('hidden');
                    } else {
                        tabContent.classList.add('hidden');
                    }
                });
            });
        });
    </script>
</body>
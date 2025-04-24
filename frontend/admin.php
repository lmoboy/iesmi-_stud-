<?php
// include_once "../utils/Database.php";

if(!isset($_SESSION["user"]) || $_SESSION["user"]["role"] != "admin") {
    header("Location: /");
    exit;
}
// $db = new Database;
// 

// $users = $db->read('users', ['id' => $_SESSION['user']['id']]);
// if(count($users) == 0) {
//     header("Location: /");
//     exit;
// }
// if($users[0]['role'] != 'admin') {
//     header("Location: /");
//     exit;
// }
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
                    <?php for($i = 0; $i < 10; $i++): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td>John Doe</td>
                        <td>Student</td>
                        <td>
                            <a href="/edit-user?id=<?= $i + 1 ?>" class="btn btn-primary btn-sm">Edit</a>
                            <a href="/delete-user?id=<?= $i + 1 ?>" class="btn btn-error btn-sm">Delete</a>
                        </td>
                    </tr>
                    <?php endfor; ?>
                </tbody>
            </table>
            <a href="/add-user" class="btn btn-primary">Add User</a>
        </div>
        <div id="grades" class="tabs what p-4 hidden">
            <table class="table p-4">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Subject</th>
                        <th>Grade</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php for($i = 0; $i < 10; $i++): ?>
                    <tr>
                        <td>John Doe</td>
                        <td>Math</td>
                        <td>90</td>
                        <td>
                            <a href="/edit-grade?id=<?= $i + 1 ?>" class="btn btn-primary btn-sm">Edit</a>
                            <a href="/delete-grade?id=<?= $i + 1 ?>" class="btn btn-error btn-sm">Delete</a>
                        </td>
                    </tr>
                    <?php endfor; ?>
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
                    <?php for($i = 0; $i < 10; $i++): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td>Math</td>
                        <td>
                            <a href="/edit-subject?id=<?= $i + 1 ?>" class="btn btn-primary btn-sm">Edit</a>
                            <a href="/delete-subject?id=<?= $i + 1 ?>" class="btn btn-error btn-sm">Delete</a>
                        </td>
                    </tr>
                    <?php endfor; ?>
                </tbody>
            </table>
            <a href="/add-subject" class="btn btn-primary">Add Subject</a>
        </div>
    </div>
    <script>
        const tabs = document.querySelectorAll('.tab');
        const tabContents = document.querySelectorAll('.tabs.what');

        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
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
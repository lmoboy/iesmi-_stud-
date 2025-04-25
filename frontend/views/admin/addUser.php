<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);

    if (empty($name) || empty($password) || empty($role)) {
        $_SESSION['add_user_error'] = "Please fill in all fields.";
        header('Location: /user/addUser');
        exit();
    }

    if (strlen($password) < 8) {
        $_SESSION['add_user_error'] = "Password must be at least 8 characters long.";
        header('Location: /user/addUser');
        exit();
    }

    $userController = new userController();
    if (!$userController->createUser($name, password_hash($password, PASSWORD_DEFAULT), $role)) {
        $_SESSION['add_user_error'] = "Failed to add user.";
        header('Location: /user/addUser');
        exit();
    }

    header('Location: /user');
    exit();
}

?>

<main class="flex items-center justify-center min-h-screen bg-base-200">
    <div class="w-full max-w-sm p-8 space-y-6 bg-base-100 rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold text-center text-primary">Add User</h1>
        <?php if (isset($_SESSION['add_user_error'])): ?>
            <div class="alert alert-error mb-4"><?= $_SESSION['add_user_error'] ?></div>
            <?php unset($_SESSION['add_user_error']); ?>
        <?php endif; ?>
        <form action="/user/addUser" method="POST" class="space-y-4">
            <div class="form-control">
                <label class="label" for="name">
                    <span class="label-text">Name</span>
                </label>
                <input type="text" id="name" name="name" required class="input input-bordered w-full" />
            </div>
            <div class="form-control">
                <label class="label" for="password">
                    <span class="label-text">Password</span>
                </label>
                <input type="password" id="password" name="password" required class="input input-bordered w-full" />
            </div>
            <div class="form-control">
                <label class="label" for="role">
                    <span class="label-text">Role</span>
                </label>
                <select id="role" name="role" required class="select select-bordered w-full">
                    <option value="" disabled selected>Select a role</option>
                    <option value="teacher">Teacher</option>
                    <option value="student">Student</option>
                </select>
            </div>
            <div class="form-control mt-6">
                <button type="submit" class="btn btn-primary w-full">Add User</button>
            </div>
        </form>
    </div>
</main>

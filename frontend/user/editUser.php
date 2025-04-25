<?php
require_once __DIR__ . '/utils/Database.php';

if (!$data['id']) {
    header('Location: /admin');
    exit();
}

$db = new Database();

$user = $db->read('users', ['id' => intval($data['id'])])[0];

if (!$user) {
    header('Location: /admin');
    exit();
}
?>

<form method="POST" class="space-y-4">
    <div class="form-control">
        <label class="label" for="name">
            <span class="label-text">Name</span>
        </label>
        <input type="text" id="name" name="name" value="<?= $user['name'] ?>" required class="input input-bordered w-full" />
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
            <option value="student" <?= $user['role'] === 'student' ? 'selected' : '' ?>>Student</option>
            <option value="teacher" <?= $user['role'] === 'teacher' ? 'selected' : '' ?>>Teacher</option>
            <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
        </select>
    </div>
    <div class="form-control mt-6">
        <button type="submit" class="btn btn-primary w-full">Edit User</button>
    </div>
    <?php if (isset($error)): ?>
        <div class="alert alert-error mt-4"><?= $error ?></div>
    <?php endif; ?>
</form>

<?php
require_once './backend/core/gradeController.php';

if (isset($_SESSION['user'])) {
    $gc = new gradeController();
    $grades = $gc->getUserGrades($_SESSION['user']['id']);
    // var_dump($grades);
    $notifications = NULL;

    foreach ($grades as $grade) {
        if ($grade['notified'] == 1) {

            $notifications += 1;
        }
    }

}
?>


<div class="flex items-center justify-between">
    <div class="flex items-center space-x-4">
        <a href="/" class="text-xl font-bold text-primary">IESMIŅŠ_STUDĒ</a>
    </div>
    <div class="flex items-center space-x-4">
        <?php if (isset($_SESSION['user'])): ?>
            <?php if ($notifications >= 1): ?>
                <a href="/notifications">

                    <p
                        style="display: flex; border-radius: 100%; background: red; width: 40px; height: 40px; justify-content: center; align-items: center;">
                        <?= $notifications ?>
                    </p>

                </a>
            <?php endif; ?>
            <a href="/grades" class="text-lg text-base-content/70">Grades</a>
            <a href="/<?= $_SESSION['user']['role'] ?>"
                class="text-lg text-base-content/70"><?= ucfirst($_SESSION['user']['role']) ?></a>
            <div class="dropdown dropdown-end">
                <label tabindex="0" class`="btn btn-ghost btn-circle avatar">
                    <div class="w-10 roun`ded-full">
                        <img src="/backend/files/<?= $_SESSION['user']['profile_picture'] ?>" />
                    </div>
                </label>
                <ul tabindex="0" class="mt-3 p-2 shadow menu dropdown-content bg-base-100 rounded-box w-52">
                    <li><a href="/profile">Profile</a></li>
                    <li><a href="/settings">Settings</a></li>
                    <li><a href="/backend/logout">Log out</a></li>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</div>
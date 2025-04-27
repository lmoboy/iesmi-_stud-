<div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <a href="/" class="text-xl font-bold text-primary">IESMIŅŠ_STUDĒ</a>
        </div>
        <div class="flex items-center space-x-4">
            <?php if (isset($_SESSION['user'])): ?>
                <a href="/grades" class="text-lg text-base-content/70">Grades</a>
                <a href="/<?= $_SESSION['user']['role'] ?>" class="text-lg text-base-content/70"><?= ucfirst($_SESSION['user']['role']) ?></a>
                <div class="dropdown dropdown-end">
                    <label tabindex="0" class="btn btn-ghost btn-circle avatar">
                        <div class="w-10 rounded-full">
                            <img src="/backend/files/<?=$_SESSION['user']['profile_picture']?>.jpg"/>
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


    <!-- /backend/files/get?picture=<?= $_SESSION['user']['profile_picture'] ?> -->
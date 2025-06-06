<?php
$user = $_SESSION['user'];
?>

<main class="container mx-auto flex items-center justify-center p-4 space-y-4 min-h-screen">
    <div class="w-2/3 max-w-4xl p-4 space-y-4 bg-base-100 rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold text-center text-primary">Profile</h1>
        <div class="tabs">
            <a class="tab tab-lg tab-bordered" href="#security">Security</a>
            <a class="tab tab-lg tab-bordered tab-active" href="#personalisation">Personalisation</a>
        </div>
        <div id="security" class="tabs what flex flex-col hidden p-4">
            <h2 class="text-xl font-bold text-center">Security</h2>
            <p class="text-center">Change your password here.</p>
            <form method="POST" action="/backend/editUserPassword" class="space-y-4">
                <div class="form-control">
                    <label class="label" for="old-password">
                        <span class="label-text">Old password</span>
                    </label>
                    <input type="password" id="old-password" name="old-password" required
                        class="input input-bordered w-full" />
                </div>
                <div class="form-control">
                    <label class="label" for="new-password">
                        <span class="label-text">New password</span>
                    </label>
                    <input type="password" id="new-password" name="new-password" required
                        class="input input-bordered w-full" />
                </div>
                <div class="form-control mt-6">
                    <p class="text-error"><?php echo $_SESSION['profile_error'] ?? '' ?></p>
                    <button type="submit" class="btn btn-primary w-full">Change password</button>
                </div>
            </form>
        </div>
        <div id="personalisation" class="tabs what flex flex-col p-4">
            <h2 class="text-xl font-bold text-center">Personalisation</h2>
            <p class="text-center">Change your name here.</p>
            <form method="POST" action="/backend/editUser" enctype="multipart/form-data" class="space-y-4">
                <div class="form-control">
                    <label class="label" for="profile-picture">
                        <span class="label-text">Profile picture</span>
                    </label>
                    <div class="avatar">
                        <div class="w-24 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">

                            <img id="profile-picture-preview"
                                src="/backend/files/<?= htmlspecialchars($_SESSION['user']['profile_picture'] ?? 'student.png') ?>"
                                class="w-full rounded-full" />
                        </div>
                        <input type="file" id="profile-picture" name="profile-picture" class="hidden"
                            onchange="document.getElementById('profile-picture-preview').src = window.URL.createObjectURL(this.files[0])" />
                    </div>
                </div>
                <div class="form-control">
                    <label class="label" for="name">
                        <span class="label-text">Name</span>
                    </label>
                    <input type="text" id="name" name="name" value="<?= htmlspecialchars($user['name']) ?>" required
                        class="input input-bordered w-full" />
                </div>
                <p class="text-error"><?php echo $_SESSION['profile_error'] ?? '' ?></p>
                <div class="form-control mt-6">
                    <button type="submit" class="btn btn-primary w-full">Change name</button>
                </div>
            </form>
        </div>
    </div>
</main>

<script>













    const tabs = document.querySelectorAll('.tab');
    const tabContents = document.querySelectorAll('.tabs.what');
    document.addEventListener('DOMContentLoaded', function () {
        let hash = window.location.hash;
        // Default to #personalisation if no hash or invalid hash
        const validHashes = Array.from(tabs).map(tab => tab.getAttribute('href'));
        if (!hash || !validHashes.includes(hash)) {
            hash = '#personalisation';
            window.location.hash = hash;
        }
        tabs.forEach(tab => {
            if (tab.getAttribute('href') === hash) {
                tab.classList.add('tab-active');
            } else {
                tab.classList.remove('tab-active');
            }
        });
        tabContents.forEach(tabContent => {
            if (tabContent.id === hash.substring(1)) {
                tabContent.classList.remove('hidden');
                tabContent.style.display = 'block';
            } else {
                tabContent.classList.add('hidden');
                tabContent.style.display = 'none';
            }
        });
    });


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
                    tabContent.style.display = 'block';
                } else {
                    tabContent.classList.add('hidden');
                    tabContent.style.display = 'none';
                }
            });
        });
    });
</script>
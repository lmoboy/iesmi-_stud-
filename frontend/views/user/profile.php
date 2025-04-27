<?php
$user = $_SESSION['user'];

?>

<main class="container mx-auto flex items-center justify-center p-4 space-y-4">
    <div class="w-2/3 max-w-4xl p-4 space-y-4 bg-base-100 rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold text-center text-primary">Profile</h1>
        <div class="tabs">
            <a class="tab tab-lg tab-bordered" href="#security">Security</a>
            <a class="tab tab-lg tab-bordered tab-active" href="#personalisation">Personalisation</a>
        </div>
        <div id="security" class="tabs what flex flex-col hidden p-4">
            <h2 class="text-xl font-bold text-center">Security</h2>
            <p class="text-center">Change your password here.</p>
            <form method="POST" class="space-y-4">
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
                    <button type="submit" class="btn btn-primary w-full">Change password</button>
                </div>
            </form>
        </div>
        <div id="personalisation" class="tabs what flex flex-col p-4">
            <h2 class="text-xl font-bold text-center">Personalisation</h2>
            <p class="text-center">Change your name here.</p>
            <form method="POST" class="space-y-4">
                <div class="form-control">
                    <label class="label" for="profile-picture">
                        <span class="label-text">Profile picture</span>
                    </label>
                    <div class="avatar">
                        <div class="w-24 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">

                            <img id="profile-picture-preview" src="/backend/files/<?=$_SESSION['user']['profile_picture']?>.jpg"
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
                    <input type="text" id="name" name="name" value="<?= $user['name'] ?>" required
                        class="input input-bordered w-full" />
                </div>
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
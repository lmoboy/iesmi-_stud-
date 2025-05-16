<?php
$user = $_SESSION['user'];
?>
<main class="min-h-screen">
    <h1 class="text-3xl font-bold text-center">Add User</h1>
    <div class="flex items-center justify-center min-h-screen bg-base">
        <div class="w-full max-w-sm p-6 space-y-6 bg-base-100 rounded-lg shadow-lg">
            <form action="/backend/addUser" method="POST" class="space-y-4">
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
                <p class="text-error"><?php echo $_SESSION['addUser_error'] ?? '' ?></p>
                    <button type="submit" class="btn btn-primary w-full">Add User</button>
                </div>
            </form>
        </div>
    </div>
</main>

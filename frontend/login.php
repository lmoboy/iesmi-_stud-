<?php
if (isset($_SESSION['login_error'])) {
    echo '<div class="alert alert-error mb-4">'.$_SESSION['login_error'].'</div>';
    unset($_SESSION['login_error']);
}
?>

<main class="flex items-center justify-center min-h-screen bg-base-200">
    <div class="w-full max-w-sm p-8 space-y-6 bg-base-100 rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold text-center text-primary">Login</h1>
        <form action="/backend/login" method="POST"   class="space-y-4">
            <div class="form-control">
                <label class="label" for="email">
                    <span class="label-text">Email</span>
                </label>
                <input type="email" id="email" name="email" required class="input input-bordered w-full" />
            </div>
            <div class="form-control">
                <label class="label" for="password">
                    <span class="label-text">Password</span>
                </label>
                <input type="password" id="password" name="password" required class="input input-bordered w-full" />
            </div>
            <div class="form-control mt-6">
                <button type="submit" class="btn btn-primary w-full">Login</button>
            </div>
        </form>
    </div>
</main>
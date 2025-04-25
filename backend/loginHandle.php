<?php
require_once './utils/logging.php';
require_once './utils/Database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    debug_log('Processing login attempt');
    $name = trim($_POST['name']);
    $password = trim($_POST['password']);

    if (empty($name) || empty($password)) {
        debug_log('Login attempt failed: Empty name or password', 'warning');
        $_SESSION['login_error'] = "Please fill in all fields.";
        header('Location: /');
        exit();
    }

    debug_log("Attempting authentication for user: {$name}");
    $db = new Database();

    $user = $db->read('users', ['name' => $name])[0];

    if ($user && password_verify($password, $user['password'])) {
        debug_log("Authentication successful for user: {$name}");
        // Store only necessary user data in session
        $_SESSION['user'] = [
            'id' => $user['id'],
            'name' => $user['name'],
            'role' => $user['role'] ?? 'user',
            'profile_picture' => $user['profile_picture']
        ];
        // Regenerate session ID for security
        session_regenerate_id(true);
        debug_log("Session regenerated for user: {$name}");
        header('Location: /');
        exit();
    } else {
        debug_log("Authentication failed for user: {$name}", 'warning');
        $_SESSION['login_error'] = "Invalid name or password.";
        header('Location: /');
        exit();
    }
}

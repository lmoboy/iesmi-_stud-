<?php
include_once '../Database.php';
include_once '../logging.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $db = new Database();
    $db->connect();
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    debug_log("User credentials: {$email}, {$password}");
    if (!empty($email) && !empty($password)) {
        debug_log("Checking user credentials");
        // Use correct table name 'user' instead of 'users'
        $result = $db->query('SELECT * FROM user WHERE email = :email AND password = :password', ['email' => $email, 'password' => $password]);
        debug_log("Query result: " . $result->rowCount());
        if ($result->rowCount() > 0) {
            debug_log("User found");
            $_SESSION['user'] = $result->fetch();
            header('Location: /');
            exit;
        }
        debug_log("No user found with provided credentials");
        $_SESSION['login_error'] = 'Invalid email or password.';
        header('Location: /');
        exit;
    } else {
        debug_log("Invalid email or password");
        $_SESSION['login_error'] = 'Invalid email or password.';
        header('Location: /');
        exit;
    }
}

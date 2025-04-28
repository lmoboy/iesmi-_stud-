<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IESMINS_STUDE</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script defer src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

</html>

<?php
require_once './utils/config.php';
require_once './utils/Router.php';
require_once './utils/View.php';
require_once './utils/Database.php';
require_once './utils/SMW.php';

$router = new Router();


//--------------------------------BACKEND--------------------------------

$router->addRoute('POST', '/backend/login', function () {
    require_once './backend/handlers/auth.php';
});


$router->addRoute('GET', '/backend/logout', function () {
    session_destroy();
    header('Location: /');
    exit;
});

$router->addRoute('GET', '/backend/files/get', function () {
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    $pictureName = $_GET['picture'];

    foreach ($allowedExtensions as $extension) {
        $filePath = __DIR__ . '/backend/files/' . $pictureName . '.' . $extension;
        if (file_exists($filePath)) {

            header('content-type: image/jpeg');
            switch (pathinfo($filePath)['extension']) {
                case 'png':
                    $image = imagecreatefrompng($filePath);
                    break;
                case 'gif':
                    $image = imagecreatefromgif($filePath);
                    break;
                default:
                    $image = imagecreatefromjpeg($filePath);
            }

            echo imagejpeg($image);
            imagedestroy($image);
        }
    }
    http_response_code(404);
    echo "File not found.";
});



//--------------------------------FRONTEND--------------------------------
$router->addRoute('GET', '/', function () {
    if (isset($_SESSION['user'])) {
        View::render('generic/home');
    } else {
        View::render('generic/login');
    }
});

$router->addRoute('GET', '/profile', function () {
    if (isset($_SESSION['user'])) {
        View::render('user/profile');
    } else {
        header("Location: /");
        exit;
    }
});

$router->addRoute('POST', '/profile', function () {
    require_once './backend/core/userController.php';
    $user = $_SESSION['user'];
    if (isset($_SESSION['user'])) {
        $userCOntroller = new userController();
        var_dump($_POST);
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if (isset($_POST['name'])) {
                $_SESSION['profile_error'] = "Please fill in all fields.";
                header('Location: /profile');
                exit();
            }
            if (empty(trim($_POST['name']))) {
                $_SESSION['profile_error'] = "Please fill in all fields.";
                header('Location: /profile');
                exit();
            }

            if (!$userCOntroller->editUser($name,null,$user['id'])) {
                $_SESSION['profile_error'] = "Failed to update name.";
                header('Location: /profile');
                exit();
            }
            header('Location: /profile');
            exit();
        }
        View::render('user/profile');
    } else {
        header("Location: /");
        exit;
    }
});

$router->addRoute('GET', '/grade', function(){
    if (!isset($_SESSION['user'])) {
        header("Location: /");
        exit;
    }
    $userID = $_SESSION['user']['id'];
    if (isset($_GET['user_id']) && SimpleMiddleWare::validRole('teacher, admin')) {
        $userID = $_GET['user_id'];
    }
    View::render('student/studentGrade', ['user_id'=>$userID, 'id'=>$_GET['id']]);
});

$router->addRoute("GET", "/grades", function () {
    if (!isset($_SESSION['user'])) {
        header("Location: /");
        exit;
    }
    $userID = $_SESSION['user']['id'];
    if (isset($_GET['user_id']) && SimpleMiddleWare::validRole('teacher, admin')) {
        $userID = $_GET['user_id'];
    }
    View::render('student/studentGrades', ['user_id' => $userID]);
});

$router->addRoute("GET", "/subject", function () {
    if (!isset($_SESSION['user'])) {
        header("Location: /");
        exit;
    }
    $userID = $_SESSION['user']['id'];
    if (isset($_GET['user_id']) && SimpleMiddleWare::validRole('teacher, admin')) {
        $userID = $_GET['user_id'];
        debug_log("ID changed to:" . $userID);
    }
    debug_log("Final user ID:" . $userID);


    View::render('student/subjectGrades', ['id' => $_GET['id'], 'user_id' => $userID]);
});

$router->addRoute("GET", "/teacher", function () {
    if (!isset($_SESSION['user'])) {
        header("Location: /");
        exit;
    }
    View::render('teacher/teacher');
});

$router->addRoute("GET", "/student", function () {
    if (!isset($_SESSION['user'])) {
        header("Location: /");
        exit;
    }
    View::render('student');
});









//----------------------------FRONTEND-ADMIN---------------------------------


$router->addRoute("GET", "/admin", function () {
    if (!isset($_SESSION['user']) || !SimpleMiddleWare::validRole('admin')) {
        header("Location: /");
        exit;
    }
    View::render('admin/admin');
});

$router->addRoute("GET", "/add-user", function () {
    if (!isset($_SESSION['user']) || !SimpleMiddleWare::validRole('admin')) {
        header("Location: /");
        exit;
    }
    View::render('user/addUser');
});

$router->addRoute('GET', '/edit-user', function () {
    if (!isset($_SESSION['user']) || !SimpleMiddleWare::validRole('admin')) {
        header("Location: /");
        exit;
    }
    $userID = $_GET['id'];
    View::render('user/editUser', ['id' => $userID]);
});

$router->handleRequest();
?>
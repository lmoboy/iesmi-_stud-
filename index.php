<?php

$lines = file('.env');
foreach ($lines as $line) {
    [$key, $value] = explode('=', $line, 2);
    $key = trim($key);
    $value = trim($value);

    putenv(sprintf('%s=%s', $key, $value));
    $_ENV[$key] = $value;
    $_SERVER[$key] = $value;
}

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

$router->addRoute('POST', '/backend/editUser', function () {
    require_once './backend/handlers/editUser.php';
});

$router->addRoute('POST', '/backend/editUserPassword', function () {
    require_once './backend/handlers/editUserPassword.php';
});

$router->addRoute('POST', '/backend/addUser', function () {
    require_once './backend/handlers/addUser.php';
});

$router->addRoute('POST', '/backend/editGrade', function () {
    require_once './backend/handlers/editGrade.php';
});


$router->addRoute('GET', '/export', function () {
    require_once './backend/handlers/csvExport.php';
    $userID = $_GET['user_id'] ?? $_SESSION['user']['id'];
    $export = new CSVExport();
    $export->exportUser($userID);

});


$router->addRoute('GET', '/export-grade', function () {
    if (!isset($_GET['id'])) {
        header("Location: /");
        exit;
    }
    require_once './backend/handlers/csvExport.php';
    $export = new CSVExport();
    $export->exportLesson($_GET['id']);
});



$router->addRoute('POST', '/backend/addGrade', function () {
    require_once './backend/handlers/addGrade.php';
});

$router->addRoute('POST', '/backend/addSubject', function () {
    require_once './backend/handlers/addSubject.php';
});

//--------------------------------FRONTEND--------------------------------
$router->addRoute('GET', '/', function () {
    if (isset($_SESSION['user'])) {
        View::render('generic/home');
    } else {
        View::render('generic/login');
    }
});



$router->addRoute('GET', '/notifications', function () {
    View::render("user/notifications");
});


$router->addRoute('GET', '/profile', function () {
    if (isset($_SESSION['user'])) {
        View::render('user/profile');
    } else {
        header("Location: /");
        exit;
    }
});

$router->addRoute('GET', '/edit-grade', function () {
    if (isset($_SESSION['user'])) {
        View::render('teacher/editGrade', ['id' => $_GET['id']]);
    } else {
        header("Location: /");
        exit;
    }
});
// $router->addRoute('POST', '/profile', function () {
//     require_once './backend/core/userController.php';

// });

$router->addRoute('GET', '/grade', function () {
    if (!isset($_SESSION['user'])) {
        header("Location: /");
        exit;
    }
    $userID = $_SESSION['user']['id'];
    if (isset($_GET['user_id']) && SimpleMiddleWare::validRole('teacher, admin')) {
        $userID = $_GET['user_id'];
    }
    View::render('student/studentGrade', ['user_id' => $userID, 'id' => $_GET['id']]);
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

$router->addRoute("GET", "/add-grade", function () {
    if (!isset($_SESSION['user'])) {
        header("Location: /");
        exit;
    }
    $userID = $_SESSION['user']['id'];
    if (isset($_GET['user_id']) && SimpleMiddleWare::validRole('teacher, admin')) {
        $userID = $_GET['user_id'];
    }
    View::render('teacher/addGrade', ['user_id' => $userID]);
});

$router->addRoute("GET", "/add-subject", function () {
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


    View::render('teacher/addSubject');
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
    $userID = $_SESSION['user']['id'];
    if (isset($_GET['user_id']) && SimpleMiddleWare::validRole('teacher, admin')) {
        $userID = $_GET['user_id'];
    }
    View::render('student/studentGrades', ['user_id' => $userID]);
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
    View::render('admin/editUser', ['id' => $userID]);
});

$router->handleRequest();
?>
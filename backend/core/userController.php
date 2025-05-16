<?php
include_once './utils/Database.php';
include_once './utils/logging.php';


class userController
{
    private $db;
    function __construct()
    {
        $this->db = new Database();
    }

    public function getUsers()
    {
        return $this->db->read('users', [], 'name, profile_picture, role, id');
    }

    public function checkIfUserExisst($name)
    {
        $user = $this->db->read('users', ['name' => $name], 'name, profile_picture, role, id');
        if (empty($user)) {
            return false;
        } else {
            return true;
        }
    }

    public function updateUserImage($id, $image)
    {
        if (!isset($image['tmp_name']) || !is_uploaded_file($image['tmp_name'])) {
            debug_log('No image uploaded or invalid file.');
            return false;
        }

        // Validate file type (allow only images)
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($image['type'], $allowedTypes)) {
            debug_log('Type wrong fuck off.');
            return false;
        }

        // Validate file size (max 5MB)
        if ($image['size'] > 5 * 1024 * 1024) {
            debug_log('File too fat like your mum, fuck you.');

            return false;
        }

        // Generate a unique filename
        $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
        $newFileName = uniqid('userimg_', true) . '.' . $ext;

        // Set destination directory
        $destinationDir = __DIR__ . '/../files/';
        if (!is_dir($destinationDir)) {
            debug_log('You lost???? itty bitty baby blyat.');


            mkdir($destinationDir, 0755, true);
        }
        $destination = $destinationDir . $newFileName;

        // Move the uploaded file
        if (!move_uploaded_file($image['tmp_name'], $destination)) {
            debug_log('Fuck you.');

            return false;
        }

        // Save only the relative path in the database
        $imagePath = $newFileName;
        return $this->db->update('users', ['profile_picture' => $imagePath], ['id' => $id]);
    }

    public function getUser($id)
    {
        return $this->db->read('users', ['id' => $id], 'name, profile_picture, role, id');
    }

    public function createUser($name, $password, $role)
    {
        if (!SimpleMiddleWare::validRole('admin')) {
            return false;
        }
        return $this->db->create('users', ['name' => $name, 'password' => $password, 'role' => $role]);
    }

    public function editUser($name, $id)
    {
        debug_log('new name: ' . $name);

        return $this->db->update('users', ['name' => $name], ['id' => $id]);
    }
    public function editUserPassword($newPassword, $id)
    {
        debug_log('new password for user id: ' . $id . ' is: ' . $newPassword);
        $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        return $this->db->update('users', ['password' => $newPassword], ['id' => $id]);
    }


    public function checkPassword($password, $id)
    {
        $user = $this->db->read('users', ['id' => $id]);
        return password_verify($password, $user[0]['password']);
    }
    public function deleteUser($id)
    {
        if (SimpleMiddleWare::validRole('admin')) {
            return false;
        }
        return $this->db->delete('users', ['id' => $id]);
    }

}
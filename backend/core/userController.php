<?php
include_once 'Database.php';
include_once 'logging.php';

class userController{
    private $db;
    function __construct()
    {
        $this->db = new Database();
        $this->db->connect();
    }

    public function getUsers(){
        return $this->db->read ('users');
    }

    public function getUser($id){
        return $this->db->read('users', ['id' => $id]);
    }

    public function createUser($name, $password, $role){
        if($_SESSION['user']['role'] !== 'admin'){
            return false;
        }
        return $this->db->create('users', ['name' => $name, 'password' => $password, 'role' => $role]);
    }

    public function editUser($id, $name, $password, $role){
        if($_SESSION['user']['role'] !== 'admin'){
            return false;
        }
        return $this->db->update('users', ['name' => $name, 'password' => $password, 'role' => $role], ['id' => $id]);
    }
    public function deleteUser($id){
        if($_SESSION['user']['role'] !== 'admin'){
            return false;
        }
        return $this->db->delete('users', ['id' => $id]);
    }

}
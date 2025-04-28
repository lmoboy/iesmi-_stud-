<?php
include_once './utils/Database.php';
include_once './utils/logging.php';


class userController{
    private $db;
    function __construct()
    {
        $this->db = new Database();
    }

    public function getUsers(){
        return $this->db->read('users', [], 'name, profile_picture, role, id');
    }

    public function getUser($id){
        return $this->db->read('users', ['id' => $id], 'name, profile_picture, role, id');
    }

    public function createUser($name, $password, $role){
        if(SimpleMiddleWare::validRole('admin')){
            return false;
        }
        return $this->db->create('users', ['name' => $name, 'password' => $password, 'role' => $role]);
    }

    public function editUser($name, $password = null, $id){
        if(SimpleMiddleWare::validRole('admin')){
            return false;
        }
        if(empty($password)){
            return $this->db->update('users', ['name' => $name], ['id' => $id]);
        }
        
        return $this->db->update('users', ['name' => $name, 'password' => $password], ['id' => $id]);
    }
    public function deleteUser($id){
        if(SimpleMiddleWare::validRole('admin')){
            return false;
        }
        return $this->db->delete('users', ['id' => $id]);
    }

}
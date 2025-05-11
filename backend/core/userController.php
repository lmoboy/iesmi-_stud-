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

    public function checkIfUserExisst($name){
        $user = $this->db->read('users', ['name'=>$name], 'name, profile_picture, role, id');
        if(empty($user)){
            return false;
        }else{
            return true;
        }
    }

    public function getUser($id){
        return $this->db->read('users', ['id' => $id], 'name, profile_picture, role, id');
    }

    public function createUser($name, $password, $role){
        if(!SimpleMiddleWare::validRole('admin')){
            return false;
        }
        return $this->db->create('users', ['name' => $name, 'password' => $password, 'role' => $role]);
    }

    public function editUser($name, $id){
        debug_log('new name: '.$name );

        return $this->db->update('users', ['name' => $name], ['id' => $id]);
    }
    public function editUserPassword($newPassword, $id){
        debug_log('new password for user id: '.$id.' is: '.$newPassword );
        $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        return $this->db->update('users', ['password' => $newPassword], ['id' => $id]);
    }

    public function checkPassword($password, $id){
        $user = $this->db->read('users', ['id' => $id]);
        return password_verify($password, $user[0]['password']);
    }
    public function deleteUser($id){
        if(SimpleMiddleWare::validRole('admin')){
            return false;
        }
        return $this->db->delete('users', ['id' => $id]);
    }

}
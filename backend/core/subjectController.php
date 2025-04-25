<?php
include_once './utils/Database.php';
include_once './utils/logging.php';


class subjectController{
    private $db;
    function __construct()
    {
        $this->db = new Database();
    }

    public function getSubjects()
    {
        return $this->db->read('subjects');
    }

    public function createSubject($name)
    {
        if ($_SESSION['user']['role'] !== 'admin' || $_SESSION['user']['role'] !== 'teacher') {
            return false;
        }
        return $this->db->create('subjects', ['name' => $name]);
    }

    public function editSubject($subjectID, $name){
        if($_SESSION['user']['role'] !== 'admin' || $_SESSION['user']['role'] !== 'teacher'){
            return false;
        }
        return $this->db->update('subjects', ['name' => $name], ['id' => $subjectID]);
    }

    public function deleteSubject($subjectID){
        if($_SESSION['user']['role'] !== 'admin' || $_SESSION['user']['role'] !== 'teacher'){
            return false;
        }
        return $this->db->delete('subjects', ['id' => $subjectID]);
    }

}
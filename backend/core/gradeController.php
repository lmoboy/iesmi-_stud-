<?php
include_once 'Database.php';
include_once 'logging.php';

class gradeController{
    private $db;
    function __construct()
    {
        $this->db = new Database();
    }

    public function getGrades($userID){

        return $this->db->read('grades', ['user_id' => $userID]);
    }

    public function setGrades($userID, $subjectID, $grade){
        return $this->db->create('grades', ['user_id' => $userID, 'subject_id' => $subjectID, 'grade' => $grade]);
    }

    public function addGrades($userID, $subjectID, $grade){
        if($_SESSION['user']['role'] !== 'admin' || $_SESSION['user']['role'] !== 'teacher'){
            return false;
        }
        return $this->db->create('grades', ['user_id' => $userID, 'subject_id' => $subjectID, 'grade' => $grade]);
    }

    public function removeGrade($userID, $subjectID, $grade){
        if($_SESSION['user']['role'] !== 'admin' || $_SESSION['user']['role'] !== 'teacher'){
            return false;
        }
        return $this->db->delete('grades', ['user_id' => $userID, 'subject_id' => $subjectID, 'grade' => $grade]);
    }
}
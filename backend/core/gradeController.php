<?php
include_once 'Database.php';
include_once 'logging.php';

class gradeController{
    private $db;
    function __construct()
    {
        $this->db = new Database();
        $this->db->connect();
    }

    public function getGrades($userID){
        return $this->db->query('SELECT * FROM grades WHERE user_id = :user_id ', ['user_id' => $userID]);
    }

    public function setGrades($userID, $subjectID, $grade){
        return $this->db->create('grades', ['user_id' => $userID, 'subject_id' => $subjectID, 'grade' => $grade]);
    }
}
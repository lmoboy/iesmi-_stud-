<?php
include_once './utils/Database.php';
include_once './utils/logging.php';

class gradeController
{
    private $db;
    function __construct()
    {
        $this->db = new Database();
    }

    public function getGrades()
    {
        return $this->db->read('grades');
    }
    public function getGradesFormatted()
    {
        $grades = $this->getGrades();
        $users = $this->db->read('users');
        $subjects = $this->db->read('subjects');

        $formattedGrades = [];
        foreach ($grades as $grade) {
            $formattedGrades[] = [
                'user' => $users[$grade['user_id']-1]["name"],
                'subject' => $subjects[$grade['subject_id']-1]["name"],
                'grade' => $grade['grade'],
                'id' => $grade['id']
            ];

        }
        return $formattedGrades;
    }


    public function getUserGrades($userID)
    {

        return $this->db->read('grades', ['user_id' => $userID]);
    }

    public function getSubjectGrades($subjectID)
    {
        return $this->db->read('grades', ['subject_id' => $subjectID]);
    }

    public function setGrades($userID, $subjectID, $grade)
    {
        return $this->db->create('grades', ['user_id' => $userID, 'subject_id' => $subjectID, 'grade' => $grade]);
    }

    public function addGrades($userID, $subjectID, $grade)
    {
        if ($_SESSION['user']['role'] !== 'admin' || $_SESSION['user']['role'] !== 'teacher') {
            return false;
        }
        return $this->db->create('grades', ['user_id' => $userID, 'subject_id' => $subjectID, 'grade' => $grade]);
    }

    public function updateGrade($gradeID, $grade)
    {
        if ($_SESSION['user']['role'] !== 'admin' || $_SESSION['user']['role'] !== 'teacher') {
            return false;
        }
        return $this->db->update('grades', ['grade' => $grade], ['id' => $gradeID]);
    }

    public function removeGrade($gradeID)
    {
        if ($_SESSION['user']['role'] !== 'admin' || $_SESSION['user']['role'] !== 'teacher') {
            return false;
        }
        return $this->db->delete('grades', ['id' => $gradeID]);
    }
}
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

    public function getUserGrades($id)
    {
        return $this->db->read('grades', ['user_id' => $id]);

    }


    public function setGradeRead($gradeId)
    {
        return $this->db->update("grades", ['notified' => 0], ["id" => $gradeId]);
    }

    public function getGradeById($id)
    {
        return $this->db->read('grades', ['id' => $id]);
    }
    public function getGradesFormatted($id = null)
    {
        if ($id) {
            $grades = $this->getGradeById($id);
            $users = $this->db->read('users');
            $subjects = $this->db->read('subjects');
        } else {
            $grades = $this->getGrades();
            $users = $this->db->read('users');
            $subjects = $this->db->read('subjects');
        }

        $formattedGrades = [];
        foreach ($grades as $grade) {
            $formattedGrades[] = [
                'user' => $users[$grade['user_id'] - 1]["name"],
                'teacher' => $users[$grade['teacher_id'] - 1]["name"],
                'subject' => $subjects[$grade['subject_id'] - 1]["name"],
                'grade' => $grade['grade'],
                'id' => $grade['id']
            ];

        }
        return $formattedGrades;
    }


    public function addGrades($userID, $subjectID, $grade)
    {
        if (!SimpleMiddleWare::validRole('teacher,admin')) {
            return false;
        }
        return $this->db->create('grades', ['user_id' => $userID, 'subject_id' => $subjectID, 'grade' => $grade, 'teacher_id' => $_SESSION['user']['id']]);
    }

    public function updateGrade($gradeID, $grade, $subjectID)
    {
        if (!SimpleMiddleWare::validRole('teacher,admin')) {
            return false;
        }
        return $this->db->update('grades', ['grade' => $grade, 'subject_id' => $subjectID], ['id' => $gradeID]);
    }

    public function removeGrade($gradeID)
    {
        if (SimpleMiddleWare::validRole('teacher,admin')) {
            return false;
        }
        return $this->db->delete('grades', ['id' => $gradeID]);
    }
}
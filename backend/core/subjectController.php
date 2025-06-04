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
    
    public function getSubjectsByName($name)
    {
        return $this->db->read('subjects', ['name'=>$name]);
    }

    public function getSubjectById($id){
        return $this->db->read('subjects', ['id'=>$id]);
    }

    public function createSubject($name)
    {
        if (!SimpleMiddleWare::validRole('teacher,admin')) {
            return false;
        }
        return $this->db->create('subjects', ['name' => $name]);
    }

    public function checkIfSubjectExists($subject_name){
        $query = "SELECT COUNT(*) AS count FROM subjects WHERE name = :name";
        $result = $this->db->query($query, [':name' => $subject_name]);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row['count'] > 0;

    }

    public function editSubject($subjectID, $name){
        if(SimpleMiddleWare::validRole('teacher,admin')){
            return false;
        }
        return $this->db->update('subjects', ['name' => $name], ['id' => $subjectID]);
    }

    public function deleteSubject($subjectID){
        if(SimpleMiddleWare::validRole('teacher,admin')){
            return false;
        }
        return $this->db->delete('subjects', ['id' => $subjectID]);
    }

}
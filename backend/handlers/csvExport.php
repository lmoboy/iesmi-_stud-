<?php
require_once './backend/core/gradeController.php';
require_once './backend/core/userController.php';
require_once './backend/core/subjectController.php';



class CSVExport
{
    private $gc;
    private $uc;
    private $sc;


    public function __construct()
    {
        $this->gc = new gradeController();
        $this->uc = new userController();
        $this->sc = new subjectController();
    }


    public function exportUser($userID)
    {



        $userGrades = $this->gc->getUserGrades($userID);



        $subjects = $this->sc->getSubjects();


        $subjectMap = [];
        if (!empty($subjects)) {
            foreach ($subjects as $subject) {
                $subjectMap[$subject['id']] = $subject['name'];
            }
        }


        $csvData = [];


        $csvData[] = ['Subject Name', 'Grade', "Teacher Name", 'Month Added'];


        if (!empty($userGrades)) {
            foreach ($userGrades as $grade) {

                $subjectId = $grade['subject_id'];
                $gradeValue = $grade['grade'];
                $teacherId = $grade['teacher_id'];
                $createdAt = $grade['created_at'];


                $subjectName = $subjectMap[$subjectId] ?? 'Unknown Subject';



                $teacher = $this->uc->getUser($teacherId)[0];
                $teacherName = $teacher['name'] ?? 'Unknown Teacher';


                $monthAdded = date('F', strtotime($createdAt));


                $csvData[] = [$subjectName, $gradeValue, $teacherName, $monthAdded];
            }
        }

        $userController = new userController();
        $user = $userController->getUser($userID)[0];
        $username = $user['name'] ?? 'unknown_user';
        $filename = "grades_{$username}_" . date('Y-m-d_H-i-s') . ".csv";




        if (count($csvData) == 0) {

        }
        ob_start();
        $df = fopen("php://output", 'w');
        // fputcsv(stream: $df, fields: array_keys(reset($csvData)), escape: "\n");
        foreach ($csvData as $row) {
            echo "\n";
            fputcsv(stream: $df, fields: $row, escape: "");
        }
        fclose($df);
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');
        echo ob_get_clean();

    }

    public function exportLesson($subjectID)
    {





        $subjects = $this->sc->getSubjectGrades($subjectID);
        $map = $this->sc->getSubjects();
        $subjectMap = [];
        if (!empty($map)) {
            foreach ($map as $subject) {
                $subjectMap[$subject['id']] = $subject['name'];
            }
        }


        $csvData = [];


        $csvData[] = ['Grade', 'Student name', "Teacher Name", 'Month Added'];


        if (!empty($subjects)) {
            foreach ($subjects as $grade) {

                $subjectId = $grade['subject_id'];
                $gradeValue = $grade['grade'];
                $teacherId = $grade['teacher_id'];
                $createdAt = $grade['created_at'];


                $subjectName = $subjectMap[$subjectId] ?? 'Unknown Subject';


                $student = $this->uc->getUser($grade['user_id'])[0];
                $studentName = $student['name'] ?? 'Unknown Student';

                $teacher = $this->uc->getUser($teacherId)[0];
                $teacherName = $teacher['name'] ?? 'Unknown Teacher';


                $monthAdded = date('F', strtotime($createdAt));


                $csvData[] = [$gradeValue, $studentName, $teacherName, $monthAdded];
            }
        }
        $userController = new userController();
        // $user = $userController->getUser($userID)[0];
        // $username = $user['name'] ?? 'unknown_user';
        $filename = "grades_" . date('Y-m-d_H-i-s') . ".csv";

        // echo '<pre>';
        // var_dump($csvData[1]);
        // echo '</pre>';



        if (count($csvData) == 0) {

        }
        ob_start();
        $df = fopen("php://output", 'w');
        // fputcsv(stream: $df, fields: array_keys(reset($csvData)), escape: "\n");
        foreach ($csvData as $row) {
            echo "\n";
            fputcsv(stream: $df, fields: $row, escape: "");
        }
        fclose($df);
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');
        echo ob_get_clean();

    }


}


?>
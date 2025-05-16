<?php
require_once './backend/core/gradeController.php';
require_once './backend/core/userController.php';
require_once './backend/core/subjectController.php';



class CSVExport
{
    public function __construct($userID)
    {

        $gc = new gradeController();
        $uc = new userController();
        $sc = new subjectController();




        $userGrades = $gc->getUserGrades($userID);



        $subjects = $sc->getSubjects();


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



                $teacher = $uc->getUser($teacherId)[0];
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
}

$csvc = new CSVExport($_GET['id'] ?? $_SESSION['user']['id']);

?>
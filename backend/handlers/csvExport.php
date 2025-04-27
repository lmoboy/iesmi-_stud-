<?php
require_once './backend/core/gradeController.php';
require_once './backend/core/userController.php';
require_once './backend/core/subjectController.php';




function exportCSVGradesForUser($userID)
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


    $csvData[] = ['Subject Name', 'Grade', 'Teacher Name', 'Month Added'];


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
    return $csvData;
}

function array2csv($array)
{
    if (count($array) == 0) {
        return null;
    }
    ob_start();
    $df = fopen("php://output", 'w');
    fputcsv(stream: $df, fields: array_keys(reset($array)), escape: "");
    foreach ($array as $row) {
        echo "<br>";
        fputcsv(stream: $df, fields: $row, escape: "");
    }
    fclose($df);
    return ob_get_clean();
}
echo (array2csv(exportCSVGradesForUser(1)));















?>
<?php
    $directory = '';
    if($createdByTutor){
        $directory = '../';
    } else {
        $directory = '../includes/';
    }
    /* achievement questions*/
    require $directory.'ExamClasses/NCEALVL1/AlgebraicProcedures/Achievement/exam_ap_u_1.inc.php';
    require $directory.'ExamClasses/NCEALVL1/AlgebraicProcedures/Achievement/exam_ap_u_2.class.php';

    /* merit questions*/
    require $directory.'ExamClasses/NCEALVL1/AlgebraicProcedures/Merit/exam_ap_r_1.inc.php';
    require $directory.'ExamClasses/NCEALVL1/AlgebraicProcedures/Merit/exam_ap_r_2.class.php';

    /* excellence questions*/
    require $directory.'ExamClasses/NCEALVL1/AlgebraicProcedures/Excellence/exam_ap_t_1.inc.php';
?>
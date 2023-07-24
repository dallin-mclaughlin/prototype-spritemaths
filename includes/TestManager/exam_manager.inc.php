<?php

    //Develop a code system that is more clear for the switch cases
    
    //total number of questions asked in the test
    $num_questions = 3; 
    $num_u_questions = 1; 
    $num_r_questions = 2;
    $num_t_questions = 2; 
    $questionBlurbs = [];
    $questions = [];
    $answers = [];
    $submittedanswers = [];
    $imagereferences = [];
    $submittedWorkings = [];
    $logicalReasoningPoints = [];

    $bytes = random_bytes(5);
    $testid = bin2hex($bytes);

    date_default_timezone_set('Pacific/Auckland');
    $time = time(); 

    if($createdByTutor){
        require_once '../'.$newtest.'.class.php';
    } else {
        require_once '../includes/'.$newtest.'.class.php';
    }
    $newtest = substr($newtest, strpos($newtest,'/')+1);
    $newtest = substr($newtest, strpos($newtest,'/')+1);
    

    $question_objects = [];


    switch($newtest){
        case "Algebraic_Procedures":
            for($i = 0; $i < $num_questions; $i++) {


                for($j = 0; $j < $num_u_questions; $j++){
                    $u_questions = [new algebraU1Question(), new algebraU2Question()];
                    
                    $ran_num = rand(0, count($u_questions)-1);
                    $ran_num = 1;
                    array_push($question_objects, $u_questions[$ran_num]);
                }
                for($k = 0; $k < $num_r_questions; $k++){
                    $r_questions = [new algebraR1Question(), new algebraR2Question()]; 

                    $ran_num = rand(0, count($r_questions)-1);
                    array_push($question_objects, $r_questions[$ran_num]);
                }
                for($l = 0; $l < $num_t_questions; $l++){
                    $t_questions = [new algebraT1Question()];
                    
                    $ran_num = rand(0, count($t_questions)-1);
                    array_push($question_objects, $t_questions[$ran_num]);
                }
            }
            $type = $testCodeNames[$newtest];
            break;
        
    }

    for($i = 0; $i < count($question_objects); $i++){
        $question_object = $question_objects[$i];
        array_push($questionBlurbs, $question_object->getBlurb());
        array_push($answers, $question_object->toAnswer());
        array_push($questions, $question_object->toQuestion());
        array_push($submittedanswers, "");
        array_push($submittedWorkings, "");
        array_push($logicalReasoningPoints, 0);
        array_push($imagereferences, $question_object->generateImage($testid, $i));
    }

    foreach($question_objects as $question_object){
        unset($question_object);
    }

    $question_num = 0;
?>
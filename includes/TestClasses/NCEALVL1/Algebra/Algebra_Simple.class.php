<?php

    class AlgebraSimpleQuestion extends Question{   

        private $strings = ['xyz','abc','uvw'];
        private $variables = '';
        
        function __construct(){
            $this->variables = $this->strings[array_rand($this->strings)];

            $questions = ['add','multiply','exponents','roots','mixture'];
            $chooseQuestion = $questions[random_int(0,count($questions)-1)];
            $chooseQuestion = $questions[random_int(2,2)];

            if($chooseQuestion == 'add'){
                $this->additionSubtraction();
            } else if($chooseQuestion == 'multiply'){
                $this->multiplyDivide();
            } else if($chooseQuestion == 'exponents'){
                $this->exponents();
            } else if($chooseQuestion == 'roots'){
                $this->roots();
            } else if($chooseQuestion == 'mixture'){
                $this->mixture();
            }

        }


        function additionSubtraction(){
            $uniqueTerms = [];
            $uniqueTermsRepetitions = [];
            $coefficients = [];
            $repCoefficients = [];
            $finalArrangement = [];
            $numUniqueTerms = random_int(2,3);
            for($i = 0; $i < $numUniqueTerms; $i++){
                $variables = str_split($this->variables);
                //shuffle($variables);
                $term = [];
                foreach($variables as $variable){
                    $power = random_int(0,3);
                    $power = "$power";
                    $term[$variable] = $power;
                }
                array_push($uniqueTerms, $term);
                $rep = random_int(1,2);
                $coefficient = 0;
                $partCoefficients = [];
                for($j = 0; $j < $rep; $j++){
                    $repeat = (random_int(0,2))?random_int(1,5):-random_int(1,5);
                    array_push($partCoefficients, $repeat);
                    $coefficient += $repeat;
                }
                array_push($repCoefficients, $partCoefficients);
                array_push($coefficients, $coefficient);
            }

            $answer = '';
            for($i=0; $i < count($uniqueTerms); $i++){
                $term = '';
                $uniqueTerm = $uniqueTerms[$i];
                $power = current($uniqueTerm);
                while($power!==false){
                    if($power == "0"){
                    } else if($power == "1"){
                        $term .= key($uniqueTerm);
                    } else {
                        $term .= key($uniqueTerm).'^'.$power;
                    }
                    next($uniqueTerm);
                    $power = current($uniqueTerm);
                }
                if($coefficients[$i]==0){
                    continue;
                } else if($coefficients[$i]==1){
                    $answer .= $term;
                } else if($coefficients[$i] == -1){
                    $answer .= '-'.$term;
                } else {
                    $answer .= $coefficients[$i].$term;
                }
                $answer .= '+';
            }

            $fullTermRearrangement = '';
            for($i=0; $i < count($uniqueTerms); $i++){
                $repCoefficientsX = $repCoefficients[$i];
                for($j = 0; $j < count($repCoefficientsX);$j++){
                    $rearrangedTerm = '';
                    $term = '';
                    $uniqueTerm = $uniqueTerms[$i];
                    $this->shuffle_assoc($uniqueTerm);
                    $power = current($uniqueTerm);
                    while($power!==false){
                        if($power == "0"){
                        } else if($power == "1"){
                            $term .= key($uniqueTerm);
                        } else {
                            $term .= key($uniqueTerm).'^'.$power;
                        }
                        next($uniqueTerm);
                        $power = current($uniqueTerm);
                    }
                    if($repCoefficientsX[$j]==1){
                        $rearrangedTerm .= $term;
                    } else if($repCoefficientsX[$j] == -1){
                        $rearrangedTerm .= '-'.$term;
                    } else {
                        $rearrangedTerm .= $repCoefficientsX[$j].$term;
                    }
                    $rearrangedTerm .= '+';
                    $fullTermRearrangement .= $rearrangedTerm;
                    array_push($finalArrangement, $rearrangedTerm);
                }
            }

            shuffle($finalArrangement);
            $finalQuestion = '';
            foreach($finalArrangement as $unit){
                $finalQuestion .= $unit;
            }
            $finalQuestion = substr($finalQuestion, 0,-1);
            $finalQuestion = str_replace("+-","-", $finalQuestion);
            $answer = substr($answer, 0, -1);
            $answer = str_replace("+-","-", $answer);

            $this->setQuestion('\mathrm{ Simplify \ }'.$finalQuestion);
            $this->setAnswer($answer);

        }

        function multiplyDivide(){
            $option = random_int(0,6);
            if($option == 0){
                $this->multiplyDivide0();
            } else if($option == 1){
                $this->multiplyDivide1();
            } else if($option == 2){
                $this->multiplyDivide2();
            } else if($option == 3){
                $this->multiplyDivide3();
            } else if($option == 4){
                $this->multiplyDivide4();
            } else if($option == 5){
                $this->multiplyDivide5();
            } else if($option == 6){
                $this->multiplyDivide6();
            }
        }

        function multiplyDivide0(){
            $variables = str_split($this->variables);
            $powers = [$variables[0]=>0, $variables[1]=>0, $variables[2]=>0];
            $terms = [];
            for($i = 0; $i < 2; $i++){
                $term = '';
                $ran = random_int(1,3);
                for($j = 0; $j < $ran; $j++){
                    $var = array_rand($variables);
                    $variable = $variables[$var];
                    $power = random_int(0,3)?random_int(1,3):-random_int(1,3);
                    if($power == 1){
                        $term .= $variable;
                    } else if ($power < 0){
                        $term .= $variable.'^{'.$power.'}';
                    } else {
                        $term .= $variable.'^'.$power;
                    }
                    $powers[$variable] += $power;
                }
                array_push($terms, $term);
            }

            print_r($terms);
            print_r($powers);
            $answer = '';
            $variable = current($powers);
            while($variable !== false){
                if($variable == 0){

                } else if($variable == 1){
                    $answer .= key($powers);
                } else if($variable < 0){
                    $answer .= key($powers).'^{'.$variable.'}';
                } else {
                    $answer .= key($powers).'^'.$variable;
                }
                next($powers);
                $variable = current($powers);
            }

            //echo 'answer: '.$answer;
            $this->setQuestion('\mathrm{ Simplify \ } '.$terms[0].' \\times '.$terms[1]);
            $this->setAnswer($answer);
        }

        function multiplyDivide1(){
            $variables = str_split($this->variables);
            $powers = [$variables[0]=>0, $variables[1]=>0, $variables[2]=>0];
            $terms = [];
            for($i = 0; $i < 3; $i++){
                $term = '';
                $ran = random_int(1,3);
                for($j = 0; $j < $ran; $j++){
                    $var = array_rand($variables);
                    $variable = $variables[$var];
                    $power = random_int(0,3)?random_int(1,4):-random_int(1,4);
                    if($power == 1){
                        $term .= $variable;
                    } else if ($power < 0){
                        $term .= $variable.'^{'.$power.'}';
                    } else {
                        $term .= $variable.'^'.$power;
                    }
                    $powers[$variable] += $power;
                }
                array_push($terms, $term);
            }

            print_r($terms);
            print_r($powers);
            $answer = '';
            $variable = current($powers);
            while($variable !== false){
                if($variable == 0){

                } else if($variable == 1){
                    $answer .= key($powers);
                } else if($variable < 0){
                    $answer .= key($powers).'^{'.$variable.'}';
                } else {
                    $answer .= key($powers).'^'.$variable;
                }
                next($powers);
                $variable = current($powers);
            }

            //echo 'answer: '.$answer;
            $this->setQuestion('\mathrm{ Simplify \ } '.$terms[0].' \\times '.$terms[1].' \\times '.$terms[2]);
            $this->setAnswer($answer);
            
        }

        function multiplyDivide2(){
            $variables = str_split($this->variables);
            $powers = [$variables[0]=>0, $variables[1]=>0, $variables[2]=>0];
            $terms = [];
            for($i = 0; $i < 2; $i++){
                $term = '';
                $ran = random_int(1,3);
                for($j = 0; $j < $ran; $j++){
                    $var = array_rand($variables);
                    $variable = $variables[$var];
                    $power = random_int(0,3)?random_int(1,3):-random_int(1,3);
                    if($power == 1){
                        $term .= $variable;
                    } else if ($power < 0){
                        $term .= $variable.'^{'.$power.'}';
                    } else {
                        $term .= $variable.'^'.$power;
                    }
                    if($i == 0){
                        $powers[$variable] += $power;
                    } else {
                        $powers[$variable] -= $power;
                    }
                }
                array_push($terms, $term);
            }

            print_r($terms);
            print_r($powers);
            $answer = '';
            $variable = current($powers);
            while($variable !== false){
                if($variable == 0){

                } else if($variable == 1){
                    $answer .= key($powers);
                } else if($variable < 0){
                    $answer .= key($powers).'^{'.$variable.'}';
                } else {
                    $answer .= key($powers).'^'.$variable;
                }
                next($powers);
                $variable = current($powers);
            }

            //echo 'answer: '.$answer;
            $this->setQuestion('\mathrm{ Simplify \ } '.$terms[0].' \\div '.$terms[1]);
            $this->setAnswer($answer);
            
        }

        function multiplyDivide3(){
            $variables = str_split($this->variables);
            $powers = [$variables[0]=>0, $variables[1]=>0, $variables[2]=>0];
            $terms = [];
            for($i = 0; $i < 3; $i++){
                $term = '';
                $ran = random_int(1,3);
                for($j = 0; $j < $ran; $j++){
                    $var = array_rand($variables);
                    $variable = $variables[$var];
                    $power = random_int(0,3)?random_int(1,3):-random_int(1,3);
                    if($power == 1){
                        $term .= $variable;
                    } else if ($power < 0){
                        $term .= $variable.'^{'.$power.'}';
                    } else {
                        $term .= $variable.'^'.$power;
                    }
                    if($i == 0){
                        $powers[$variable] += $power;
                    } else {
                        $powers[$variable] -= $power;
                    }
                }
                array_push($terms, $term);
            }

            print_r($terms);
            print_r($powers);
            $answer = '';
            $variable = current($powers);
            while($variable !== false){
                if($variable == 0){

                } else if($variable == 1){
                    $answer .= key($powers);
                } else if($variable < 0){
                    $answer .= key($powers).'^{'.$variable.'}';
                } else {
                    $answer .= key($powers).'^'.$variable;
                }
                next($powers);
                $variable = current($powers);
            }

            //echo 'answer: '.$answer;
            $this->setQuestion('\mathrm{ Simplify \ } '.$terms[0].' \\div \left('.$terms[1].' \\times '.$terms[2].' \right)');
            $this->setAnswer($answer);
            
        }

        function multiplyDivide4(){
            $variables = str_split($this->variables);
            $powers = [$variables[0]=>0, $variables[1]=>0, $variables[2]=>0];
            $terms = [];
            for($i = 0; $i < 3; $i++){
                $term = '';
                $ran = random_int(1,3);
                for($j = 0; $j < $ran; $j++){
                    $var = array_rand($variables);
                    $variable = $variables[$var];
                    $power = random_int(0,3)?random_int(1,4):-random_int(1,4);
                    if($power == 1){
                        $term .= $variable;
                    } else if ($power < 0){
                        $term .= $variable.'^{'.$power.'}';
                    } else {
                        $term .= $variable.'^'.$power;
                    }
                    $powers[$variable] += $power;
                }
                array_push($terms, $term);
            }

            print_r($terms);
            print_r($powers);
            $answer = '';
            $variable = current($powers);
            while($variable !== false){
                if($variable == 0){

                } else if($variable == 1){
                    $answer .= key($powers);
                } else if($variable < 0){
                    $answer .= key($powers).'^{'.$variable.'}';
                } else {
                    $answer .= key($powers).'^'.$variable;
                }
                next($powers);
                $variable = current($powers);
            }

            //echo 'answer: '.$answer;
            $this->setQuestion('\mathrm{ Simplify \ } \left( '.$terms[0].' \\times '.$terms[1].' \right) \\times '.$terms[2]);
            $this->setAnswer($answer);
        }

        function multiplyDivide5(){
            $variables = str_split($this->variables);
            $powers = [$variables[0]=>0, $variables[1]=>0, $variables[2]=>0];
            $terms = [];
            for($i = 0; $i < 3; $i++){
                $term = '';
                $ran = random_int(1,3);
                for($j = 0; $j < $ran; $j++){
                    $var = array_rand($variables);
                    $variable = $variables[$var];
                    $power = random_int(0,3)?random_int(1,4):-random_int(1,4);
                    if($power == 1){
                        $term .= $variable;
                    } else if ($power < 0){
                        $term .= $variable.'^{'.$power.'}';
                    } else {
                        $term .= $variable.'^'.$power;
                    }
                    if($i == 2){
                        $powers[$variable] -= $power;
                    } else {
                        $powers[$variable] += $power;
                    }
                }
                array_push($terms, $term);
            }

            print_r($terms);
            print_r($powers);
            $answer = '';
            $variable = current($powers);
            while($variable !== false){
                if($variable == 0){

                } else if($variable == 1){
                    $answer .= key($powers);
                } else if($variable < 0){
                    $answer .= key($powers).'^{'.$variable.'}';
                } else {
                    $answer .= key($powers).'^'.$variable;
                }
                next($powers);
                $variable = current($powers);
            }

            //echo 'answer: '.$answer;
            $this->setQuestion('\mathrm{ Simplify \ } \left( '.$terms[0].' \\times '.$terms[1].' \right) \\div '.$terms[2]);
            $this->setAnswer($answer);
        }

        function multiplyDivide6(){
            $variables = str_split($this->variables);
            $powers = [$variables[0]=>0, $variables[1]=>0, $variables[2]=>0];
            $terms = [];
            for($i = 0; $i < 3; $i++){
                $term = '';
                $ran = random_int(1,3);
                for($j = 0; $j < $ran; $j++){
                    $var = array_rand($variables);
                    $variable = $variables[$var];
                    $power = random_int(0,3)?random_int(1,4):-random_int(1,4);
                    if($power == 1){
                        $term .= $variable;
                    } else if ($power < 0){
                        $term .= $variable.'^{'.$power.'}';
                    } else {
                        $term .= $variable.'^'.$power;
                    }
                    if($i == 2){
                        $powers[$variable] -= $power;
                    } else {
                        $powers[$variable] += $power;
                    }
                }
                array_push($terms, $term);
            }

            print_r($terms);
            print_r($powers);
            $answer = '';
            $variable = current($powers);
            while($variable !== false){
                if($variable == 0){

                } else if($variable == 1){
                    $answer .= key($powers);
                } else if($variable < 0){
                    $answer .= key($powers).'^{'.$variable.'}';
                } else {
                    $answer .= key($powers).'^'.$variable;
                }
                next($powers);
                $variable = current($powers);
            }

            //echo 'answer: '.$answer;
            $this->setQuestion('\mathrm{ Simplify \ } '.$terms[0].' \\times '.$terms[1].' \\div '.$terms[2]);
            $this->setAnswer($answer);
        }

        function exponents(){
            $variables = str_split($this->variables);
            $powers = [$variables[0]=>0, $variables[1]=>0, $variables[2]=>0];
            $numeral = random_int(2,5);
            $terms = [];
            $powerBracket = random_int(2,4);
            $num = random_int(1,1);
            for($i = 0; $i < $num; $i++){
                $term = '';
                $ran = random_int(1,4);
                for($j = 0; $j < $ran; $j++){
                    $var = array_rand($variables);
                    $variable = $variables[$var];
                    $power = random_int(0,3)?random_int(1,4):-random_int(1,4);
                    if($power == 1){
                        $term .= $variable;
                    } else {
                        $term .= $variable.'^{'.$power.'}';
                    }
                    $powers[$variable] += $power*$powerBracket;   
                }
                array_push($terms, $term);
            }

            $answer = '';
            $variable = current($powers);
            while($variable !== false){
                if($variable == 0){

                } else if($variable == 1){
                    $answer .= key($powers);
                } else if($variable < 0){
                    $answer .= key($powers).'^{'.$variable.'}';
                } else {
                    $answer .= key($powers).'^'.$variable;
                }
                next($powers);
                $variable = current($powers);
            }
            //echo 'answer: '.$answer;
            $this->setQuestion('\mathrm{ Simplify \ } \\left( '.$terms[0].' \\right)^{'.$powerBracket.'}');
            $this->setAnswer($answer);
            
        }

        function roots(){
            $variables = str_split($this->variables);
            $powers = [$variables[0]=>0, $variables[1]=>0, $variables[2]=>0];
            $terms = [];
            $root = random_int(2,4);
            $num = random_int(1,1);
            for($i = 0; $i < $num; $i++){
                $term = '';
                $ran = random_int(1,4);
                for($j = 0; $j < $ran; $j++){
                    $var = array_rand($variables);
                    $variable = $variables[$var];
                    $power = random_int(0,3)?random_int(1,4)*$root:-random_int(1,4)*$root;
                    if($power == 1){
                        $term .= $variable;
                    } else {
                        $term .= $variable.'^{'.$power.'}';
                    }
                    $powers[$variable] += $power/$root;   
                }
                array_push($terms, $term);
            }

            $answer = '';
            $variable = current($powers);
            while($variable !== false){
                if($variable == 0){

                } else if($variable == 1){
                    $answer .= key($powers);
                } else if($variable < 0){
                    $answer .= key($powers).'^{'.$variable.'}';
                } else {
                    $answer .= key($powers).'^'.$variable;
                }
                next($powers);
                $variable = current($powers);
            }
            //echo 'answer: '.$answer;
            $this->setQuestion('\mathrm{ Simplify \ } \\sqrt['.$root.']{'.$terms[0].'}');
            $this->setAnswer($answer);

        }

        function mixture(){

        }
    }

?>



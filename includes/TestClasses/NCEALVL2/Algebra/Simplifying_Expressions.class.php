<?php

    class SimplifyExpressions extends Question{
        
        private $answer;
        private $question;

        private $questionExpression;
        private $answerExpression;

        private $variables = array('a','b','x','y','n');

        private $ran;
        private $blurb = [];

        function __construct(){
            $this->Question();
            $this->Answer();
        }

        function getBlurb(){
            return $this->blurb;
        }
        

        function pickExpression(){
            $this->ran = random_int(0,5);
            //$this->ran = 2;

            switch($this->ran){
                case 0:
                    $this->generateFirst();
                    break;
                case 1:
                    $this->generateSecond();
                    break;
                case 2:
                    $this->generateThird();
                    break;
                case 3:
                    $this->generateFourth();
                    break;
                case 4:
                    $this->generateFifth();
                    break;
                case 5:
                    $this->generateSixth();
                    break;
            }
        }

        function generateFirst(){
            $probability = array(0,0,1,1,1,1);
            $number = random_int(2,6);
            $variable = $this->variables[array_rand($this->variables)];
            $exponent1 = (random_int(0,1))?random_int(2,4):-random_int(2,4);
            $exponent2 = ($probability[array_rand($probability)])?random_int(2,4):-random_int(2,4);

            $this->questionExpression = '\frac{\left('.$number.$variable.'\right)^{'.$exponent1.'}}{'.$number.$variable.'^{'.$exponent2.'}}';
            $this->answerExpression = pow($number,$exponent1-1).$variable.'^{'.($exponent1-$exponent2).'}';
        }

        function generateSecond(){
            $number = random_int(2,6);
            $variable = $this->variables[array_rand($this->variables)];
            $exponent1 = random_int(2,4);
            $exponent2 = random_int(2,4);

            $this->questionExpression = '\frac{'.$number.$variable.'^'.$exponent1.'}{'.$number.$variable.'^'.$exponent2.'}';
            $this->answerExpression = $variable.'^{'.($exponent1-$exponent2).'}';
        }

        function generateThird(){
            $number = random_int(2,6);
            $variable = $this->variables[array_rand($this->variables)];
            echo $variable;
            $exponent1 = random_int(2,3);
            $exponent2 = random_int(2,3);
            $exponent3 = random_int(2,3);

            $this->questionExpression = '\frac{'.$number.'^{'.$exponent1.'}'.$variable.'^{'.$exponent2.'}}{\left('.$number.$variable.'\right)^{'.$exponent3.'}}';
            $this->answerExpression = $number.'^{'.($exponent1-$exponent3).'}'.$variable.'^{'.($exponent2-$exponent3).'}';
        }

        function generateFourth(){
            $number = random_int(2,6);
            $variable = $this->variables[array_rand($this->variables)];
            $exponent1 = random_int(2,3);
            $exponent2 = random_int(2,3);
            $exponent3 = random_int(2,3);
            $exponent4 = random_int(2,3);
            $exponent5 = random_int(2,3);
            $exponent6 = random_int(2,3);

            $this->questionExpression = '\frac{\left('.$number.'^{'.$exponent1.'}'.$variable.'^{'.$exponent2.'}\right)^{'.$exponent3.'}}{\left('.$number.'^{'.$exponent4.'}'.$variable.'^{'.$exponent5.'}\right)^{'.$exponent6.'}}';
            $this->answerExpression = $number.'^{'.($exponent1*$exponent3-$exponent4*$exponent6).'}'.$variable.'^{'.($exponent2*$exponent3-$exponent5*$exponent6).'}';
        }

        function generateFifth(){
            $number = random_int(2,6);
            $variable = $this->variables[array_rand($this->variables)];
            $exponent1 = random_int(2,3);
            $exponent2 = random_int(2,3);

            $this->questionExpression = '\sqrt['.$exponent1.']{'.pow($number,$exponent1).$variable.'^{'.$exponent1*$exponent2.'}}';
            $this->answerExpression = $number.$variable.'^{'.$exponent2.'}';
        }

        function generateSixth(){
            $number = random_int(2,4);
            $variable1 = $this->variables[array_rand($this->variables)];
            $variable2 = $this->variables[array_rand($this->variables)];
            $exponent1 = random_int(2,3);
            $exponent2 = random_int(2,3);
            $exponent3 = random_int(2,4);

            $this->questionExpression = '\left('.pow($number, 2*$exponent1).$variable1.'^{'.(2*$exponent2).'}'.$variable2.'^{'.(2*$exponent3).'}\right)^{0.5}';
            $this->answerExpression = pow($number, $exponent1).$variable1.'^{'.$exponent2.'}'.$variable2.'^{'.$exponent3.'}';
        }

        function generateImage($id, $num){
            return '';
        }
        

        function Question(){
            $this->pickExpression();
            $this->question = '\mathrm{\ Simplify \ }'.$this->questionExpression;

        }

        function Answer(){
            $this->answer = $this->answerExpression;
        }

        function getQuestion(){
            return $this->question;
        }

        function getAnswer(){
            return $this->answer;
        }
    }
?>
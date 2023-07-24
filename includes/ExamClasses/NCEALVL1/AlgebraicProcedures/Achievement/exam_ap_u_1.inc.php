<?php
    class algebraU1Question
    {

        private $question;
        private $answer;

        private $variables = [];
        private $values = [];
        private $string;
        private $strings = ['xyz','abc','uvw'];

        private $ran_int;

        private $expression = '';
        private $sum = 0;

        private $blurb = [];

        function __construct(){
            $this->Question();
            $this->Answer();
        }

        function generateQuestion(){
            $latexExpression = '\mathrm{Evaluate \ }'.$this->expression.' \mathrm{ \ given \ }';
            for($i = 0; $i < count($this->variables); $i++){
                $latexExpression .= $this->variables[$i].'='.$this->values[$i];
                if($i != (count($this->variables)-1)){
                    $latexExpression .= ', \ ';
                }
            }
            $this->question = $latexExpression;
        }

        function generateExpression(){
            $length = random_int(2,5);
            for($i = 0; $i < $length; $i++){
                $ran_sign = random_int(0,1);
                $ran_coefficient = random_int(1,6);
                $ran_power = random_int(0,3);

                $ran_select = random_int(0,count($this->variables)-1);

                $ran_variable = $this->variables[$ran_select];
                $variable_value = $this->values[$ran_select];

                //creating the latex expression
                if($ran_sign){
                    if($i==0){
                        $this->expression .= '';
                    } else {
                        $this->expression .= '+';
                    }
                } else {
                    $this->expression .= '-';
                }

                if($ran_coefficient!=1){   
                    $this->expression .= $ran_coefficient;
                } else {
                    if($ran_power == 0){
                        $this->expression .= $ran_coefficient;
                    }
                }

                if($ran_power==0){
                    $this->expression .= '';
                } else if($ran_power==1){
                    $this->expression .= $ran_variable;
                } else {
                    $this->expression .= $ran_variable.'^'.$ran_power;
                }

                //adding to the sum
                if($ran_sign){
                    $this->sum += $ran_coefficient * $variable_value ** $ran_power;
                } else {
                    $this->sum -= $ran_coefficient * $variable_value ** $ran_power;
                }
            }
        }

        function pickString(){
            $this->ran_int = random_int(0, count($this->strings)-1);
            $this->string = $this->strings[$this->ran_int];

            for($i = 0; $i < strlen($this->string); $i++){
                $ran = random_int(0,1);
                if($ran){
                    $this->variables[] = $this->string[$i];
                    
                    $chanceArray = [1,1,1,1,1,0,0,0];
                    $chance = $chanceArray[random_int(0,count($chanceArray)-1)];
                    //echo $chance.'this is the chance.';

                    if($chance){
                        $this->values[] = random_int(1,3);
                    } else {
                        $this->values[] = random_int(1,3) * (-1);
                    }
                        $this->values[] = random_int(1,3);
                }
            }

            if(count($this->variables) == 0){
                $ran = random_int(0,strlen($this->string)-1);
                $this->variables[] = $this->string[$ran];
                
                $chanceArray = [1,1,1,1,1,0,0,0];
                $chance = $chanceArray[random_int(0,count($chanceArray)-1)];
                //echo $chance.'this is the chance.';

                if($chance){
                    $this->values[] = random_int(1,3);
                } else {
                    $this->values[] = random_int(1,3) * (-1);
                }
            }
            //print_r($this->string);
            //print_r($this->variables);
            //print_r($this->values);
        }

        function getBlurb(){
            return $this->blurb;
        }

        function generateImage($id, $num)
        {
            return '';
        }

        function Question()
        {
            $this->pickString();
            $this->generateExpression();
            $this->generateQuestion();
        }

        function Answer()
        {
            $this->answer = $this->sum;
        }

        function toQuestion()
        {
            return $this->question;
        }

        function toAnswer()
        {
            return $this->answer;
        }


    }

    //Redo this whole question please!
?>
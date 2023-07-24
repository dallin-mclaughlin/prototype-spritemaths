<?php

    class ExpandingQuadraticsQuestion extends Question{
        
        private $answer;
        private $question;
        private $cheatAnswers = [];

        private $bracketForm = '';
        private $expandedForm = '';

        private $vars = '';
        private $vars1 = 'uv';
        private $vars2 = 'xy';
        private $vars3 = 'ts';
        private $numbers1 = array(0,0,0,0,0,0,0,0,0,0,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,2,2,2,2,3,3,3,3,3
                                  -1,-1,-1,-2,-2,-2,-3,-3,-3);
        private $numbers2 = array(0,0,0,0,0,0,0,0,0,0,0,0,1,2,3,4,5,6,-1,-2,-3,-4,-5,-6);
        private $numbers3 = array(1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,2,2,2,2,3,3,3,3,4,4,4,4
                                  -1,-1,-1,-2,-2,-2,-3,-3,-4,-4);
        private $varsArray = array();

        private $bracketFormArray = array();
        private $expandedFormArray = array();

        function __construct(){
            $this->Question();
            $this->Answer();
        }

        private $blurb = [];
        function getBlurb(){
            return $this->blurb;
        }
        
        function generateImage($id, $num){
            return ''; 
        }

        function fillArray(){
            $this->varsArray[] = $this->vars1; 
            $this->varsArray[] = $this->vars2;           
            $this->varsArray[] = $this->vars3;
        }

        function pickVars() {
            $n = random_int(0,2);
            $this->vars = $this->varsArray[$n];
        }

        function generateBracketFormArray(){
            
            $int = random_int(0,count($this->numbers1)-1);
            array_push($this->bracketFormArray, $this->numbers1[$int]);

            if ($this->bracketFormArray[0]!=0){
                $int = random_int(0, count($this->numbers2)-1);
                array_push($this->bracketFormArray, $this->numbers2[$int]);
            } else {
                $int = random_int(array_search(2,$this->numbers2), count($this->numbers2)-1);
                array_push($this->bracketFormArray, $this->numbers2[$int]);
            }
            
            //this piece of codes allows a chance of creating a quadratic like the following: (x+a)(x-a)
            $chancesSquare = array(0,1);
            $chance = $chancesSquare[random_int(0,count($chancesSquare)-1)];
            
            if($chance && $this->bracketFormArray[0]!=0 && $this->bracketFormArray[1]!=0){
                array_push($this->bracketFormArray, $this->bracketFormArray[0]);
                array_push($this->bracketFormArray, -$this->bracketFormArray[1]);
            } else {
                $int = random_int(0,count($this->numbers3)-1);
                array_push($this->bracketFormArray, $this->numbers3[$int]);

                $int = random_int(1,5);
                array_push($this->bracketFormArray, $int);
            }
        }

        function generateExpandedFormArray(){
            array_push($this->expandedFormArray, $this->bracketFormArray[0]*$this->bracketFormArray[2]);
            array_push($this->expandedFormArray, $this->bracketFormArray[0]*$this->bracketFormArray[3]+
                                                 $this->bracketFormArray[1]*$this->bracketFormArray[2]);
            array_push($this->expandedFormArray, $this->bracketFormArray[1]*$this->bracketFormArray[3]);
        }

        function generateBracketForm(){
            if($this->bracketFormArray[0] == 0){
                $this->bracketForm = $this->bracketFormArray[1].'\left('.$this->bracketFormArray[2].$this->vars[0].'+'
                                .$this->bracketFormArray[3].'\right)';
            } else if ($this->bracketFormArray[1] == 0){
                $this->bracketForm = $this->bracketFormArray[0].$this->vars[0].'\left('.$this->bracketFormArray[2].$this->vars[0].'+'
                                .$this->bracketFormArray[3].'\right)';
            } else if($this->bracketFormArray[0]==$this->bracketFormArray[2]&&$this->bracketFormArray[1]==$this->bracketFormArray[3]) {
                $this->bracketForm = '\left('.$this->bracketFormArray[0].$this->vars[0].'+'.$this->bracketFormArray[1].'\right)^2';
            } else {
                $this->bracketForm = '\left('.$this->bracketFormArray[0].$this->vars[0].'+'.$this->bracketFormArray[1].'\right)\left('
                                .$this->bracketFormArray[2].$this->vars[0].'+'.$this->bracketFormArray[3].'\right)';
            }

        }

        function generateExpandedForm(){

            if($this->expandedFormArray[0] != 0 && $this->expandedFormArray[0] != 1 && $this->expandedFormArray[0] != -1){
                $this->expandedForm .= $this->expandedFormArray[0].$this->vars[0].'^2+';
            } else if($this->expandedFormArray[0] == 1){
                $this->expandedForm .= $this->vars[0].'^2+';
            } else if($this->expandedFormArray[0] == -1){
                $this->expandedForm .= '-'.$this->vars[0].'^2+';
            }

            if($this->expandedFormArray[1] != 0 && $this->expandedFormArray[1] != 1 && $this->expandedFormArray[1] != -1){
                $this->expandedForm .= $this->expandedFormArray[1].$this->vars[0].'+';
            } else if($this->expandedFormArray[1] == 1){
                $this->expandedForm .= $this->vars[0].'+';
            } else if($this->expandedFormArray[1] == -1){
                $this->expandedForm .= '-'.$this->vars[0].'+';
            }

            if($this->expandedFormArray[2] != 0){
                $this->expandedForm .= $this->expandedFormArray[2];
            }
        }


        function simplifyBracketForm(){
            $this->bracketForm = str_replace("1".$this->vars[0],$this->vars[0], $this->bracketForm);
            $this->bracketForm = str_replace("-1".$this->vars[0],'-'.$this->vars[0], $this->bracketForm);
            $this->bracketForm = str_replace("-1\left(","-\left(", $this->bracketForm);
            $this->bracketForm = str_replace("+-","-", $this->bracketForm);
        }

        function simplifyExpandedForm(){
            $order = array($this->vars[0].'^0', '^1');
            $this->expandedForm = str_replace($order,"", $this->expandedForm);

            while(substr($this->expandedForm,-1)=='+'|| substr($this->expandedForm,-1)=='-'){
                $this->expandedForm = substr($this->expandedForm, 0, -1);
            }
            $this->expandedForm = str_replace("+-","-", $this->expandedForm);
        }

        function Question(){
            $this->fillArray();
            $this->pickVars();
            $this->generateBracketFormArray();
            $this->generateExpandedFormArray();
            $this->generateBracketForm(); 
            $this->generateExpandedForm();
            $this->simplifyBracketForm();
            $this->simplifyExpandedForm();
            $this->question = "\mathrm{\ Expand \ and \ simplify \ \ }".$this->bracketForm;
            array_push($this->cheatAnswers, $this->bracketForm);
        }

        function Answer(){
            $this->answer = $this->expandedForm;
        }

        function getQuestion(){
            return $this->question;
        }

        function getAnswer(){
            return $this->answer;
        }
    }

    //need to fix code so that -1 for x^2 and x^1 isn't included in the expanded form
?>

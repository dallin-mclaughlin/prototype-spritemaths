<?php

    class FactorisingQuadraticsQuestion extends Question{
        
        private $answer;

        private $bracketForm = '';
        private $factoredBracketForm = '';
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
        private $additionalFactor = 1;

        private $bracketFormArray = array();
        private $expandedFormArray = array();
        private $factoredBracketFormArray = array();

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
            array_push($this->factoredBracketFormArray, $this->numbers1[$int]);

            if ($this->bracketFormArray[0]!=0){
                $int = random_int(0, count($this->numbers2)-1);
                array_push($this->bracketFormArray, $this->numbers2[$int]);
                array_push($this->factoredBracketFormArray, $this->numbers2[$int]);
            } else {
                $int = random_int(array_search(2,$this->numbers2), count($this->numbers2)-1);
                array_push($this->bracketFormArray, $this->numbers2[$int]);
                array_push($this->factoredBracketFormArray, $this->numbers2[$int]);
            }

            //this piece of codes allows a 1/10 chance of creating a quadratic like the following: (x+a)(x-a)
            $chancesSquare = array(0,1);
            $chance = $chancesSquare[random_int(0,count($chancesSquare)-1)];
            
            if($chance && $this->bracketFormArray[0]!=0 && $this->bracketFormArray[1]!=0){
                array_push($this->bracketFormArray, $this->bracketFormArray[0]);
                array_push($this->factoredBracketFormArray, $this->factoredBracketFormArray[0]);

                array_push($this->bracketFormArray, -$this->bracketFormArray[1]);
                array_push($this->factoredBracketFormArray, -$this->factoredBracketFormArray[1]);
            } else {
                $int = random_int(0,count($this->numbers3)-1);
                array_push($this->bracketFormArray, $this->numbers3[$int]);
                array_push($this->factoredBracketFormArray, $this->numbers3[$int]);

                $int = random_int(1,5);
                array_push($this->bracketFormArray, $int);
                array_push($this->factoredBracketFormArray, $int);
            }


            //now check if common factors exist in the two brackets
        }

        function pullFactorsBracketForm(){
            $maxfactor = 20;
            if($this->factoredBracketFormArray[0] == 0){
                for($i = 2; $i < $maxfactor; $i++){
                    if($this->factoredBracketFormArray[2]%$i==0 && $this->factoredBracketFormArray[3]%$i==0){
                        $this->factoredBracketFormArray[1] *= $i;
                        $this->factoredBracketFormArray[2] /= $i;
                        $this->factoredBracketFormArray[3] /= $i;
                    }
                }

                if($this->factoredBracketFormArray[2]<0){
                    $this->factoredBracketFormArray[1] *= -1;
                    $this->factoredBracketFormArray[2] *= -1;
                    $this->factoredBracketFormArray[3] *= -1;
                }
            } else if($this->factoredBracketFormArray[1] == 0){
                for($i = 2; $i < $maxfactor; $i++){
                    if($this->factoredBracketFormArray[2]%$i==0 && $this->factoredBracketFormArray[3]%$i==0){
                        $this->factoredBracketFormArray[0] *= $i;
                        $this->factoredBracketFormArray[2] /= $i;
                        $this->factoredBracketFormArray[3] /= $i;
                    }
                } 

                if($this->factoredBracketFormArray[2]<0){
                    $this->factoredBracketFormArray[0] *= -1;
                    $this->factoredBracketFormArray[2] *= -1;
                    $this->factoredBracketFormArray[3] *= -1;
                }

            } else {
                for($i = 2; $i < $maxfactor; $i++){
                    if($this->factoredBracketFormArray[0]%$i==0 && $this->factoredBracketFormArray[1]%$i==0){
                        $this->additionalFactor *= $i;
                        $this->factoredBracketFormArray[0] /= $i;
                        $this->factoredBracketFormArray[1] /= $i;
                    }
                } 

                if($this->factoredBracketFormArray[0]<0){
                    $this->additionalFactor *= -1;
                    $this->factoredBracketFormArray[0] *= -1;
                    $this->factoredBracketFormArray[1] *= -1;
                }

                for($i = 2; $i < $maxfactor; $i++){
                    if($this->factoredBracketFormArray[2]%$i==0 && $this->factoredBracketFormArray[3]%$i==0){
                        $this->additionalFactor *= $i;
                        $this->factoredBracketFormArray[2] /= $i;
                        $this->factoredBracketFormArray[3] /= $i;
                    }
                } 

                if($this->factoredBracketFormArray[2]<0){
                    $this->additionalFactor *= -1;
                    $this->factoredBracketFormArray[2] *= -1;
                    $this->factoredBracketFormArray[3] *= -1;
                }
            }
        }

        function generateExpandedFormArray(){
            array_push($this->expandedFormArray, $this->bracketFormArray[0]*$this->bracketFormArray[2]);
            array_push($this->expandedFormArray, $this->bracketFormArray[0]*$this->bracketFormArray[3]+
                                                 $this->bracketFormArray[1]*$this->bracketFormArray[2]);
            array_push($this->expandedFormArray, $this->bracketFormArray[1]*$this->bracketFormArray[3]);
            //print_r($this->bracketFormArray);
            //print_r($this->expandedFormArray);
        }

        function generateBracketForm(){
            if($this->bracketFormArray[0] == 0){
                $this->bracketForm = $this->bracketFormArray[1].'\left('.$this->bracketFormArray[2].$this->vars[0].'+'
                                .$this->bracketFormArray[3].'\right)';
            } else if ($this->bracketFormArray[1] == 0){
                $this->bracketForm = $this->bracketFormArray[0].$this->vars[0].'\left('.$this->bracketFormArray[2].$this->vars[0].'+'
                                .$this->bracketFormArray[3].'\right)';
            } else {
                $this->bracketForm = '\left('.$this->bracketFormArray[0].$this->vars[0].'+'.$this->bracketFormArray[1].'\right)\left('
                                .$this->bracketFormArray[2].$this->vars[0].'+'.$this->bracketFormArray[3].'\right)';
            }
            //echo $this->bracketForm;
        }

        function generateFactoredBracketForm(){
            if($this->factoredBracketFormArray[0] == 0){
                $this->factoredBracketForm = $this->factoredBracketFormArray[1].'\left('.$this->factoredBracketFormArray[2].$this->vars[0].'+'
                                .$this->factoredBracketFormArray[3].'\right)';
            } else if ($this->factoredBracketFormArray[1] == 0){
                $this->factoredBracketForm = $this->factoredBracketFormArray[0].$this->vars[0].'\left('.$this->factoredBracketFormArray[2].
                $this->vars[0].'+'.$this->factoredBracketFormArray[3].'\right)';
            } else {
                if($this->factoredBracketFormArray[0]==$this->factoredBracketFormArray[2]&&$this->factoredBracketFormArray[1]==
                   $this->factoredBracketFormArray[3]){
                    $this->factoredBracketForm = $this->additionalFactor.'\left('.$this->factoredBracketFormArray[0].$this->vars[0].'+'.
                    $this->factoredBracketFormArray[1].'\right)^2';
                } else {
                    //echo 'this is the additional factor '.$this->additionalFactor;
                    $this->factoredBracketForm = $this->additionalFactor.'\left('.$this->factoredBracketFormArray[0].$this->vars[0].'+'.
                    $this->factoredBracketFormArray[1].'\right)\left('.$this->factoredBracketFormArray[2].$this->vars[0].'+'.
                    $this->factoredBracketFormArray[3].'\right)';
                }
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

            //echo $this->expandedForm;

            if($this->expandedFormArray[1] != 0 && $this->expandedFormArray[1] != 1 && $this->expandedFormArray[1] != -1){
                $this->expandedForm .= $this->expandedFormArray[1].$this->vars[0].'+';
            } else if($this->expandedFormArray[1] == 1){
                $this->expandedForm .= $this->vars[0].'+';
            } else if($this->expandedFormArray[1] == -1){
                $this->expandedForm .= '-'.$this->vars[0].'+';
            }

            //echo $this->expandedForm;

            if($this->expandedFormArray[2] != 0){
                $this->expandedForm .= $this->expandedFormArray[2];
            }

            //echo $this->expandedForm;
        }


        function simplifyBracketForm(){
            $this->bracketForm = str_replace("1".$this->vars[0],$this->vars[0], $this->bracketForm);
            //echo $this->bracketForm;
            $this->bracketForm = str_replace("+-","-", $this->bracketForm);
            //echo $this->bracketForm;
        }

        function simplifyFactoredBracketForm(){
            $this->factoredBracketForm = str_replace("1\left(","\left(",$this->factoredBracketForm);
            $this->factoredBracketForm = str_replace("1".$this->vars[0],$this->vars[0], $this->factoredBracketForm);
            $this->factoredBracketForm = str_replace("+-","-", $this->factoredBracketForm);
            //echo 'this is the simplified factored bracket form '.$this->factoredBracketForm;
        }

        function simplifyExpandedForm(){
            $order = array($this->vars[0].'^0', '^1');
            $this->expandedForm = str_replace($order,"", $this->expandedForm);
            //echo $this->expandedForm;

            while(substr($this->expandedForm,-1)=='+'|| substr($this->expandedForm,-1)=='-'){
                $this->expandedForm = substr($this->expandedForm, 0, -1);
            }
            //echo $this->expandedForm;
            $this->expandedForm = str_replace("+-","-", $this->expandedForm);
            //echo $this->expandedForm;
        }

        function Question(){
            $this->fillArray();
            $this->pickVars();
            $this->generateBracketFormArray();
            $this->generateExpandedFormArray();
            //$this->generateBracketForm(); 
            $this->generateExpandedForm();
            //$this->simplifyBracketForm();
            $this->simplifyExpandedForm();
            $this->pullFactorsBracketForm();
            $this->generateFactoredBracketForm();
            $this->simplifyFactoredBracketForm();
            //print_r($this->factoredBracketFormArray);
        }

        function Answer(){
            //$this->answer = $this->bracketForm;
            $this->answer = $this->factoredBracketForm;
        }

        function getQuestion(){
            return "\mathrm{\ Factorise \ \ }".$this->expandedForm;
        }

        function getAnswer(){
            return $this->answer;
        }
    }

    // changing the values of the factorisedFormArray values if there is a common factor between them to get the real factorised value
?>
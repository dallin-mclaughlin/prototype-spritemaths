<?php

    //this needs to be revised sorely!!
    class SimplifyExponentQuestion extends Question{
        
        private $answer;

        private $exponentExpression;
        private $simplifiedExponentExpression;

        private $vars = '';
        private $vars1 = 'uv';
        private $vars2 = 'xy';
        private $vars3 = 'ts';
        private $varsArray = array();

        private $exponentArray = array();
        private $simplifiedExponentArray = array();

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

        function float2rat($n, $tolerance = 1.e-6) {
            if($n == 0) return "0";
            $h1=1; $h2=0;
            $k1=0; $k2=1;
            $b = 1/$n;
            do {
                $b = 1/$b;
                $a = floor($b);
                $aux = $h1; $h1 = $a*$h1+$h2; $h2 = $aux;
                $aux = $k1; $k1 = $a*$k1+$k2; $k2 = $aux;
                $b = $b-$a;
            } while (abs($n-$h1/$k1) > $n*$tolerance);

            return "$h1/$k1";
        }

        function generateExponentExpressionArray(){
            $n = 8;
            //(a_1(a_2*x^a_3)^a_4)/(a_5(a_6*x^a_7)^a^8)
            for($i = 0; $i < $n; $i++){
                array_push($this->exponentArray, random_int(1,4));
            }

            //Now make either a_4 = 0, a_8 = 0 or both not equal to zero
            $chance = random_int(0,2);

            if($chance == 0){
                $this->exponentArray[3] = 0;
            } else if($chance == 1){
                $this->exponentArray[7] = 0;
            }
            //print_r($this->exponentArray);
        }

        function generateSimplifiedExponentExpressionArray(){
            if($this->exponentArray[3]!=0 && $this->exponentArray[7]!=0){
                array_push($this->simplifiedExponentArray, ($this->exponentArray[0]*($this->exponentArray[1]**
                    $this->exponentArray[3]))/($this->exponentArray[4]*($this->exponentArray[5]**$this->exponentArray[7])));
                array_push($this->simplifiedExponentArray, $this->exponentArray[2]*$this->exponentArray[3] - 
                    $this->exponentArray[6]*$this->exponentArray[7]);
            } else if($this->exponentArray[7]==0){
                array_push($this->simplifiedExponentArray, ($this->exponentArray[0]*($this->exponentArray[1]**
                    $this->exponentArray[3]))/$this->exponentArray[4]);
                array_push($this->simplifiedExponentArray, $this->exponentArray[2]*$this->exponentArray[3]);
            } else if($this->exponentArray[3]==0){
                array_push($this->simplifiedExponentArray, $this->exponentArray[0]/($this->exponentArray[4]*
                    $this->exponentArray[5]**$this->exponentArray[7]));
                array_push($this->simplifiedExponentArray, -$this->exponentArray[6]*$this->exponentArray[7]);
            }
            
            //print_r($this->simplifiedExponentArray);
        }

        function generateExponentExpression(){
            if($this->exponentArray[3]!=0 && $this->exponentArray[7]!=0){
                $this->exponentExpression = '\frac{'.$this->exponentArray[0].'\left('.$this->exponentArray[1].
                    $this->vars[0].'^'.$this->exponentArray[2].'\right)^'.$this->exponentArray[3].'}{'.
                    $this->exponentArray[4].'\left('.$this->exponentArray[5].$this->vars[0].'^'.$this->exponentArray[6].
                    '\right)^'.$this->exponentArray[7].'}';
            } else if($this->exponentArray[7]==0){
                $this->exponentExpression = '\frac{'.$this->exponentArray[0].'}{'.$this->exponentArray[4].'}\left('.
                    $this->exponentArray[1].$this->vars[0].'^'.$this->exponentArray[2].'\right)^'.$this->exponentArray[3];
            } else {
                $this->exponentExpression = '\frac{1}{'.$this->exponentArray[4].'\left('.$this->exponentArray[5].
                    $this->vars[0].'^'.$this->exponentArray[6].'\right)^'.$this->exponentArray[7].'}';
            }
        }

        function generateSimplifiedExponentExpression(){
            $this->simplifiedExponentExpression .= $this->float2rat($this->simplifiedExponentArray[0]);

            $this->simplifiedExponentExpression = str_replace('/', '}{', $this->simplifiedExponentExpression);
            $this->simplifiedExponentExpression = '\frac{'.$this->simplifiedExponentExpression.'}';
            

            //if we have a -ve power then we want to put the x on the bottom of the fraction:
            //if the fraction already exists then we want to remove the last curly bracket and add the contents to
            //string. if the fraction doesn't exist because we have a whole number 
            if($this->simplifiedExponentArray[1]<0){
                $this->simplifiedExponentExpression = substr($this->simplifiedExponentExpression,0,strlen(
                    $this->simplifiedExponentExpression)-1);
                $this->simplifiedExponentExpression .= $this->vars[0].'^{'.$this->simplifiedExponentArray[1]*(-1).'}}';
            } else if($this->simplifiedExponentArray[1]>2){
                $this->simplifiedExponentExpression .= $this->vars[0].'^{'.$this->simplifiedExponentArray[1].'}';
            } else if ($this->simplifiedExponentArray[1]==1){
                $this->simplifiedExponentExpression .= $this->vars[0];
            }
            
        }

        function Question(){
            $this->fillArray();
            $this->pickVars();
            $this->generateExponentExpressionArray();
            $this->generateSimplifiedExponentExpressionArray();
            $this->generateExponentExpression();
            $this->generateSimplifiedExponentExpression();
        }

        function Answer(){
            $this->answer = $this->simplifiedExponentExpression;
        }

        function getQuestion(){
            return "\mathrm{\ Simplify \ \ }".$this->exponentExpression;
        }

        function getAnswer(){
            return $this->answer;
        }
    }
?>
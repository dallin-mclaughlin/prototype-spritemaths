<?php

    class FractionMultiplicationQuestion extends Question{
        
        private $answer;

        private $fractionArray = array();
        private $resultFractionArray = array();

        private $fraction;
        private $resultFraction;
        
        private $ran;

        private $blurb = [];

        function __construct(){
            $this->Question();
            $this->Answer();
        }

        function getBlurb(){
            return $this->blurb;
        }
        
        function generateImage($id, $num){
            return ''; 
        }
        
        //determine whether multiplication(1) or division operation(0)
        function generateRan(){
            $this->ran = random_int(0,1);
        }

        function generateFractionArray(){
            $this->fractionArray[] = random_int(1,9);
            $this->fractionArray[] = random_int(1,9);
            $this->fractionArray[] = random_int(1,9);
            $this->fractionArray[] = random_int(1,9);
        }

        function generateResultFractionArray(){
            if($this->ran){
                $this->resultFractionArray[] = $this->fractionArray[0]*$this->fractionArray[2];
                $this->resultFractionArray[] = $this->fractionArray[1]*$this->fractionArray[3];
            } else {
                $this->resultFractionArray[] = $this->fractionArray[0]*$this->fractionArray[3];
                $this->resultFractionArray[] = $this->fractionArray[1]*$this->fractionArray[2];
            }
        }

        function generateFraction(){
            if($this->ran){
                $this->fraction = '\frac{'.$this->fractionArray[0].'}{'.$this->fractionArray[1].'}\\times\frac{'.
                    $this->fractionArray[2].'}{'.$this->fractionArray[3].'}';
            } else {
                $this->fraction = '\frac{'.$this->fractionArray[0].'}{'.$this->fractionArray[1].'}\div\frac{'.
                    $this->fractionArray[2].'}{'.$this->fractionArray[3].'}';
            }
        }

        function generateResultFraction(){
            $maxFactor = 100;
            for($i = $maxFactor; $i >= 2; $i--){
                if($this->resultFractionArray[0]%$i==0 && $this->resultFractionArray[1]%$i==0){
                    $this->resultFractionArray[0] /= $i;
                    $this->resultFractionArray[1] /= $i;
                }
            }

            if($this->resultFractionArray[1]!=1){
                $this->resultFraction = '\frac{'.$this->resultFractionArray[0].'}{'.$this->resultFractionArray[1].'}';
            } else {
                $this->resultFraction = $this->resultFractionArray[0];
            }
        }


        function Question(){
            $this->generateRan();
            $this->generateFractionArray();
            $this->generateResultFractionArray();
            $this->generateFraction();
            $this->generateResultFraction();
        }

        function Answer(){
            $this->answer = $this->resultFraction;
        }

        function getQuestion(){
            return $this->fraction;
        }

        function getAnswer(){
            return $this->answer;
        }
    }
?>
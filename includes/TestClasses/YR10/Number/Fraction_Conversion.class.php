<?php

    class FractionConversionQuestion extends Question{
        
        private $question;
        private $answer;

        private $fraction;
        private $fractionArray;
        
        private $decimal;

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
        
        function chooseQuestion(){
            $this->ran = random_int(0,1);
            $this->fractionArray[] = random_int(1,12);
            $this->fractionArray[] = random_int(1,12);

            $this->fraction = '\frac{'.$this->fractionArray[0].'}{'.$this->fractionArray[1].'}';
            $this->decimal = $this->fractionArray[0]/$this->fractionArray[1];
        }


        function Question(){
            $this->chooseQuestion();
            if($this->ran){
                $this->question = '\mathrm{\ Write \ the \ decimal \ form \ of \ '.$this->fraction.' \ to \ 2 \ d.p.}';
            } else {
                $this->question = '\mathrm{\ Write \ the \ fraction \ form \ of \ '.$this->decimal.'}';
            }
        }

        function Answer(){
            if($this->ran){
                $this->answer = $this->decimal;
            } else {
                $this->answer = $this->fraction;
            }
        }

        function getQuestion(){
            return $this->question;
        }

        function getAnswer(){
            return $this->answer;
        }
    }
?>
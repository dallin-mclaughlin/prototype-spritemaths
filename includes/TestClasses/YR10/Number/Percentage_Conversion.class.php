<?php

    class PercentageConversionQuestion extends Question{
        
        private $question;
        private $answer;

        private $percentage;
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
        
        function chooseQuestion(){
            $this->ran = random_int(0,1);
            
            $number = random_int(0,1999);
            $this->percentage = $number/10;
            $this->decimal = $number/1000;

        }

        function generateImage($id, $num){
            return ''; 
        }


        function Question(){
            $this->chooseQuestion();
            if($this->ran){
                $this->question = '\mathrm{\ Write \ the \ decimal \ form \ of \ } '.$this->percentage.'%';
            } else {
                $this->question = '\mathrm{\ Write \ } '.$this->decimal.' \mathrm{ \ as \ a \ percentage}';
            }
        }

        function Answer(){
            if($this->ran){
                $this->answer = $this->decimal;
            } else {
                $this->answer = $this->percentage;
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
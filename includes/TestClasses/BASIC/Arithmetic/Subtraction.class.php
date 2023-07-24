<?php

    class SubtractionQuestion extends Question{
        
        private $min;
        private $max;
        private $var1;
        private $var2;
        private $answer;

        private $blurb = [];
        function getBlurb(){
            return $this->blurb;
        }
        
        function __construct($min, $max){
            $this->min = $min;
            $this->max = $max;

            $this->Question();
            $this->Answer();
        }

        function generateImage($id, $num){
            return ''; 
        }

        function Question(){
            $this->var1 = random_int($this->min, $this->max);
            $this->var2 = random_int($this->min, $this->max);
            $this->answer = $this->var1 - $this->var2;
        }

        function Answer(){
            $this->answer = $this->var1 - $this->var2;
        }

        function getQuestion(){
            return '\ '.$this->var1. "-" .$this->var2;
        }

        function getAnswer(){
            return $this->answer;
        }
    }

?>
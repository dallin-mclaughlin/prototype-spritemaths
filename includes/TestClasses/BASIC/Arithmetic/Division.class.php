<?php

    class DivisionQuestion extends Question{
        
        private $min;
        private $max;
        private $divisor1;
        private $divisor2;
        private $product;


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
            $this->divisor1 = random_int($this->min, $this->max);
            $this->divisor2 = random_int($this->min, $this->max);
        }

        function Answer(){
            $this->product = $this->divisor1*$this->divisor2;
        }

        function getQuestion(){
            return '\ '.$this->product. "\div" .$this->divisor1;
        }

        function getAnswer(){
            return $this->divisor2;
        }
    }

?>
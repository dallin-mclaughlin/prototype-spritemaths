<?php

    class AdditionInverseQuestion extends Question{
        
        private $range = 100;
        private $number;
        
        private $answer;

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

        function Question(){
            $this->number = random_int(-$this->range, $this->range);
        }

        function Answer(){
            $this->answer = -$this->number;
        }

        function getQuestion(){
            return '\mathrm{What \ is \ the \ additive \ inverse \ of \ }'.$this->number. "?";
        }

        function getAnswer(){
            return $this->answer;
        }
    }

?>
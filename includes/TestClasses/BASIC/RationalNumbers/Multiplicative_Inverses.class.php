<?php

    class MultiplicationInverseQuestion extends Question{
        
        private $range = 30;
        private $number;
        private $numberInverse;
        
        private $question;
        private $answer;

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

        function genRan(){
            $this->ran = random_int(0,1);
        }

        function Question(){
            $this->genRan();
            $this->number = random_int(-$this->range, $this->range);
            if($this->ran){
                $this->question = $this->number;
            } else {
                if($this->number<0){
                    $this->numberInverse = '-\frac{1}{'.-$this->number.'}';
                } else {
                    $this->numberInverse = '\frac{1}{'.$this->number.'}';
                }
                $this->question = $this->numberInverse;
            }
        }

        function Answer(){
            if($this->ran){
                if($this->number<0){
                    $this->answer = '-\frac{1}{'.-$this->number.'}';
                } else {
                    $this->answer = '\frac{1}{'.$this->number.'}';
                }
            } else {
                $this->answer = $this->number;
            }
        }

        function getQuestion(){
            return '\mathrm{ \ What \ is \ the \ multiplicative \ inverse \ of \ }'.$this->question. '?';
        }

        function getAnswer(){
            return $this->answer;
        }
    }

?>
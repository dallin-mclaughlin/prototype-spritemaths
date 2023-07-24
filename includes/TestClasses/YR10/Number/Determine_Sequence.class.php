<?php

    //the question 'find the nth term' needs to be adjusted because the answer if the (n+1)th term
    class DetermineSequenceQuestion extends Question{

        private $sequenceCount = 10;
        
        private $question;
        private $answer;

        private $expressionCoefficients = array();
        private $coefficientOne = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0.5, 0.5, 0.5, 0.5, 1, 1, 1, 1, 
                                        1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1,2, 2, 2, 2, 3, 3, 3, 4, 4, 5, 6, 7, 8, 9);



        private $expressionString;
        private $sequenceElements = array();

        private $ran;
        private $sequenceNumber;

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
        
        function chooseRandoms(){
            $this->ran = random_int(0,1);
            $this->sequenceNumber = random_int(1,9);
        }

        function generateExpressionCoefficients(){
            $chooseCoef = random_int(0, count($this->coefficientOne)-1);
            $this->expressionCoefficients[] = $this->coefficientOne[$chooseCoef];
            $this->expressionCoefficients[] = random_int(1,9);
            $this->expressionCoefficients[] = random_int(1,12);
        }

        function generateSequenceElements() {
            for($i = 1; $i <= $this->sequenceCount; $i++){
                $this->sequenceElements[] = $this->expressionCoefficients[0]*(($i)**2)+$this->expressionCoefficients[1]*
                                            ($i)+$this->expressionCoefficients[2];
            }
        }

        function generateExpressionString(){
            if($this->expressionCoefficients[0]==0){
                if($this->expressionCoefficients[1]!=1){
                    $this->expressionString = $this->expressionCoefficients[1].'n+'.$this->expressionCoefficients[2];
                } else {
                    $this->expressionString = 'n+'.$this->expressionCoefficients[2];
                }
            } else if ($this->expressionCoefficients[0]==0.5){
                if($this->expressionCoefficients[1]!=1){
                    $this->expressionString = '\frac{1}{2}n^2+'.$this->expressionCoefficients[1].'n+'.
                    $this->expressionCoefficients[2];
                } else {
                    $this->expressionString = '\frac{1}{2}n^2+n+'.$this->expressionCoefficients[2];
                }
            } else if ($this->expressionCoefficients[0]==1){
                if($this->expressionCoefficients[1]!=1){
                    $this->expressionString = 'n^2+'.$this->expressionCoefficients[1].'n+'.
                    $this->expressionCoefficients[2];
                } else {
                    $this->expressionString = 'n^2+n+'.$this->expressionCoefficients[2];
                }
            } else {
                if($this->expressionCoefficients[1]!=1){
                    $this->expressionString = $this->expressionCoefficients[0].'n^2+'.$this->expressionCoefficients[1].
                    'n+'.$this->expressionCoefficients[2];
                } else {
                    $this->expressionString = $this->expressionCoefficients[0].'n^2+n+'.$this->expressionCoefficients[2];
                }
            }
        }


        function Question(){
            $this->chooseRandoms();
            $this->generateExpressionCoefficients();
            $this->generateSequenceElements();
            $this->generateExpressionString();
            if($this->ran){
                $suffix = '';
                if($this->sequenceNumber==1){
                    $suffix = 'st';
                } else if ($this->sequenceNumber==2){
                    $suffix = 'nd';
                } else if ($this->sequenceNumber==3){
                    $suffix = 'rd';
                } else {
                    $suffix = 'th';
                }
                $this->question = '\mathrm{\ Write \ the \ '.$this->sequenceNumber.'^{'.$suffix.'} \ term \ of \ the \ sequence }';
                $this->blurb = ['\mathrm{Given \ the \ sequence \ \ } (a_n)_{n∈N} \ = \ '.$this->expressionString];
            } else {
                $this->question = '\mathrm{\ Write \ the \ sequence \ expression \ in \ terms \ of \ \  } n ';
                $this->blurb = ['\mathrm{Given \ } \ n_1 \ = \ '.$this->sequenceElements[0].', \ n_2 \ = \ '.$this->sequenceElements[1].', \ n_3 \ = \ '.$this->sequenceElements[2].', \ n_4 \ = \ '.$this->sequenceElements[3]];
            }
        }

        function Answer(){
            if($this->ran){
                $this->answer = $this->sequenceElements[$this->sequenceNumber];
            } else {
                $this->answer = $this->expressionString;
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
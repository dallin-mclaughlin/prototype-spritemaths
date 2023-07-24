<?php
//HEIGHT OF A PERSON AND FOREARM LENGTH = 0
//ICECREAM SALES AND TEMPERATURE = 1
//PAYING OFF A NOINTEREST PAYMENT: CELLPHONE = 2 
//COMPUTER PROCESSING SPEEDS = 3
//DISTANCE TIME RELATIONSHIP d=vt = 4
    class algebraU2Question
    {
        private $blurb = []; 

        private $question;
        private $answer;

        private $variables = ['FH','TI','tD','CT','td'];
        private $linearCoefficient;
        private $constant;

        private $xvalue;
        private $yvalue;

        private $ran_int;

        function __construct(){
            $this->Question();
            $this->Answer();
        }

        function generateQuestion(){
            switch($this->ran_int){
                case 0:
                    array_push($this->blurb, '\mathrm{The \ height \ of \ a \ person, \ } H \ \mathrm{cm, \ can \ be \ estimated \ from \ the \ length \ of \ their \ forearm, \ } F \ \mathrm{cm, \ using \ the \ formula \ } H='.$this->linearCoefficient.'F+'.$this->constant.'.');
                    array_push($this->blurb, '\mathrm{If \ their \ height, \ } H, \mathrm{\ is \ '.$this->yvalue.'cm}');
                    $this->question = '\mathrm{Determine \ their \ forearm \ length \ in \ cm}';
                    break;
                case 1:
                    array_push($this->blurb, '\mathrm{The \ number \ of \ icecream \ sales, \ } I \ \mathrm{, \ can \ be \ estimated \ from \ the \ local \ outside \ temperature \ forearm, \ } T \ \mathrm{°C, \ using \ the \ formula \ } I='.$this->linearCoefficient.'T+'.$this->constant.'.');
                    array_push($this->blurb, '\mathrm{If \ the \ icecream \ sales, \ } I, \mathrm{\ is \ '.$this->yvalue.'}');
                    $this->question = '\mathrm{Determine \ the \ local \ outside \ temperature \ in \ °C}';
                    break;
                case 2:
                    array_push($this->blurb, '\mathrm{The \ interest-free \ debt \ for \ a \ cellphone, \ } D \ \mathrm{, \ can \ be \ modelled \ using \ a \ linear \ equation, \ } D='.$this->linearCoefficient.'t+'.$this->constant.', \ \mathrm{where \ t \ is \ the \ time \ in \ months}');
                    $this->question = '\mathrm{Determine \ in \ months \ the \ time \ to \ be \ debt \ free}';
                    break;
                case 3:
                    array_push($this->blurb, '\mathrm{The \ total \ cost, \ } T \ \mathrm{$, \ for \ printer \ usage \ can \ be \ modelled \ by \ the \ equation, \ } T='.$this->linearCoefficient.'C+P\ ');
                    array_push($this->blurb, '\mathrm{\ where \ }  C \mathrm{ \ is \ the \ number \ of \ cartridges \ and \ } P \mathrm{ \ is \ the \ price \ of \ the \ printer.}');
                    array_push($this->blurb, '\mathrm{If \ } P='.$this->constant.' \ \mathrm{ and \ } C='.$this->xvalue);
                    $this->question = '\mathrm{Determine \ the \ total \ cost \ in \ $}';
                    break;
                case 4:
                    array_push($this->blurb, '\mathrm{The \ equation, \ } d=vt \mathrm{, \ tells \ us \ how \ to \ calculate \ distance \ travelled \ if \ we \ know \ the \ velocity \ of \ an \ object}');
                    array_push($this->blurb, '\mathrm{If \ a \ car \ is \ travelling \ at \ '.$this->linearCoefficient.'ms^{-1}}');
                    $this->question = '\mathrm{Determine \ the \ time \ in \ seconds \ required \ to \ travel \ '.$this->yvalue.'m}';
                    break;
            }
        }

        function generateValues(){
            switch($this->ran_int){
                case 0:
                    $this->xvalue = random_int(20,40);
                    $this->yvalue = $this->linearCoefficient * $this->xvalue + $this->constant;
                    break;
                case 1:
                    $this->xvalue = random_int(-5,30);
                    $this->yvalue = $this->linearCoefficient * $this->xvalue + $this->constant;
                    break;
                case 2:
                    $this->constant = -$this->linearCoefficient * $this->xvalue;
                    $this->yvalue = 0;
                    break;
                case 3:
                    $this->xvalue = random_int(3,7);
                    $this->yvalue = $this->linearCoefficient * $this->xvalue + $this->constant;
                    break;
                case 4:
                    $this->xvalue = random_int(10,20);
                    $this->yvalue = $this->linearCoefficient * $this->xvalue;
                    break;
            }
        }

        function generateCoefficients(){
            switch($this->ran_int){
                case 0:
                    $this->linearCoefficient = random_int(1,7);
                    $this->constant = random_int(70,130);
                    break;
                case 1:
                    $this->linearCoefficient = random_int(1,5);
                    $this->constant = random_int(5,15);
                    break;
                case 2:
                    $this->linearCoefficient = random_int(-60,-40);
                    $this->xvalue = random_int(5,12);
                    break;
                case 3:
                    $this->linearCoefficient = random_int(20,40);
                    $this->constant = random_int(60,90);
                    break;
                case 4:
                    $this->linearCoefficient = random_int(5,20);
                    $this->constant = 0;
                    break;
            }
        }

        function generateQuestionNum(){
            $this->ran_int = random_int(0,count($this->variables)-1);
            //$this->ran_int = 3;
            //$this->ran_int = 4;

        }

        function getBlurb(){
            return $this->blurb;
        }

        function generateImage($id, $num)
        {
            return '';
        }

        function Question()
        {
            $this->generateQuestionNum();
            $this->generateCoefficients();
            $this->generateValues();
            $this->generateQuestion();
        }

        function Answer()
        {

            switch($this->ran_int){
                case 0:
                    $this->answer = $this->xvalue;
                    break;
                case 1:
                    $this->answer = $this->xvalue;
                    break;
                case 2:
                    $this->answer = $this->xvalue;
                    break;
                case 3:
                    $this->answer = $this->yvalue;
                    break;
                case 4:
                    $this->answer = $this->xvalue;
                    break;
            }
        }

        function toQuestion()
        {
            return $this->question;
        }

        function toAnswer()
        {
            return $this->answer;
        }


    }

    //Redo this whole question please!
?>
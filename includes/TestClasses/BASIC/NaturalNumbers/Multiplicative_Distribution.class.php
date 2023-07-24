<?php
    class MultiplicationDistributionQuestion extends Question{
        
        private $numbers = array();

        private $range = 15; 
        private $ran;
        private $number;
        
        private $question;
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

        function Question()
        {
            $this->ran = random_int(0,1);
            if($this->ran)
            {
                $this->genVer1();
                $this->simplify();
            } else {
                $this->genVer2();
                $this->simplify();
            }
        }

        function genVer1()
        {
            $nums = 3;
            for($i = 0; $i < $nums; $i++)
            {
                $this->numbers[] = random_int(-$this->range, $this->range); 
            }

            $this->question = $this->numbers[0].'('.$this->numbers[1].'+'.
                                $this->numbers[2].')';
            

            $this->number = $this->numbers[0]*($this->numbers[1] + $this->numbers[2]);
        }

        function genVer2() 
        {
            $nums = 4;
            for($i = 0; $i < $nums; $i++)
            {
                $this->numbers[] = random_int(-$this->range, $this->range); 
            }

            $this->question = '('.$this->numbers[0].'+'.$this->numbers[1].')'.'('.
                                $this->numbers[2].'+'.$this->numbers[3].')';

            $this->number = ($this->numbers[0]+$this->numbers[1])*($this->numbers[2] + $this->numbers[3]);
        }

        function simplify()
        {
            $this->question = str_replace("+-","-", $this->question);
        }

        function Answer(){
            $this->answer = $this->number;
        }

        function getQuestion(){
            return '\mathrm{\ Evaluate \ }'.$this->question;
        }

        function getAnswer(){
            return $this->answer;
        }
    }

?>
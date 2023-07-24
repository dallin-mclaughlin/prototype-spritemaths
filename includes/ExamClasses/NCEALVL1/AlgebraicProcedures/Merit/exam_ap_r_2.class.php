<?php
    class algebraR2Question
    {

        private $question;
        private $answer;


        //(_1_x+_2+)(_3_x+_4_)
        private $values = [];
        private $roots = [];
        //acx^2 + (bc + ad)x + bd = 0
        private $expanded_values = [];

        private $ran_int;

        private $expression = '';
        private $sum = 0;

        private $blurb = [];

        function __construct(){
            $this->Question();
            $this->Answer();
        }

        function generateBlurb(){
            $ran = random_int(0,2);
            if($ran==0){
                if($this->expanded_values[0]==1){
                    $this->blurb[] = '\mathrm{The \ equation \ } '.-$this->expanded_values[2].'=x^2+'.$this->expanded_values[1].'x \mathrm{ \ has \ two \ solutions, \ } p \mathrm{ \ and \ } q, \mathrm{ \ where \ } p \mathrm{ \ is \ greater \ than \ } q.';
                } else {
                    $this->blurb[] = '\mathrm{The \ equation \ } '.-$this->expanded_values[2].'='.$this->expanded_values[0].'x^2+'.$this->expanded_values[1].'x \mathrm{ \ has \ two \ solutions, \ } p \mathrm{ \ and \ } q, \mathrm{ \ where \ } p \mathrm{ \ is \ greater \ than \ } q.';
                }
            } else if ($ran==1){
                if($this->expanded_values[0]==1){
                    $this->blurb[] = '\mathrm{The \ equation \ } x^2='.$this->expanded_values[1].'x+'.$this->expanded_values[2].' \mathrm{ \ has \ two \ solutions, \ } p \mathrm{ \ and \ } q, \mathrm{ \ where \ } p \mathrm{ \ is \ greater \ than \ } q.';
                } else {
                    $this->blurb[] = '\mathrm{The \ equation \ } '.-$this->expanded_values[0].'x^2='.$this->expanded_values[1].'x+'.$this->expanded_values[2].' \mathrm{ \ has \ two \ solutions, \ } p \mathrm{ \ and \ } q, \mathrm{ \ where \ } p \mathrm{ \ is \ greater \ than \ } q.';
                }
            } else {
                if($this->expanded_values[0]==1){
                    $this->blurb[] = '\mathrm{The \ equation \ } x^2='.-$this->expanded_values[1].'x-'.$this->expanded_values[2].' \mathrm{ \ has \ two \ solutions, \ } p \mathrm{ \ and \ } q, \mathrm{ \ where \ } p \mathrm{ \ is \ greater \ than \ } q.';
                } else {
                    $this->blurb[] = '\mathrm{The \ equation \ } '.$this->expanded_values[0].'x^2='.-$this->expanded_values[1].'x-'.$this->expanded_values[2].' \mathrm{ \ has \ two \ solutions, \ } p \mathrm{ \ and \ } q, \mathrm{ \ where \ } p \mathrm{ \ is \ greater \ than \ } q.';
                }
            }
        }

        function generateAnswer(){
            $max = max($this->roots);
            $min = min($this->roots);

            $difference = $max - $min;

            $this->sum = $difference;
        }

        function generateQuestion(){
            //\mathrm{The \ equation \} 6=2x^2-11x \mathrm{ \ has \ two \ solutions, \ p \ and \ q, \ with p being greater than q.}
            $this->question = '\mathrm{Determine \ the \ value \ of \ } p-q';
        }

        function generateValues(){
            $this->values[] = random_int(1,2);
            $this->values[] = random_int(1,9);
            $this->values[] = 1;
            $this->values[] = random_int(1,9);

            $this->roots[] = -$this->values[1]/$this->values[0];
            $this->roots[] = -$this->values[3]/$this->values[2];

            $this->expanded_values[] = $this->values[0]*$this->values[2];
            $this->expanded_values[] = $this->values[0]*$this->values[3] + $this->values[1]*$this->values[2];
            $this->expanded_values[] = $this->values[1]*$this->values[3]; 

            echo 'Values: ';
            print_r($this->values);
            echo 'Roots: ';
            print_r($this->roots);
            echo 'ExpandedValues: ';
            print_r($this->expanded_values);
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
            $this->generateValues();
            $this->generateQuestion();
            $this->generateAnswer();
            $this->generateBlurb();
        }

        function Answer()
        {
            $this->answer = $this->sum;
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

    //Fix the 1 coefficients
?>
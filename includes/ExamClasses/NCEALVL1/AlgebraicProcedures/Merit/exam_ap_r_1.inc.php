<?php
    class algebraR1Question
    {
        private $question;
        private $answer;

        private $names1 = ['Henry','Michael','Rawiri','Hemi','Aroha','Angelica','George','Megan','Shannon','Travis','Story'];
        private $names2 = ['Helen','Tuesday','Monica','Artemis','Ahmed','Toronto','Tigerlily','Naia','Mary','Simeon','Marty'];

        private $numberDictionary = [
            -1 => 'one',
            -2 => 'two',
            -3 => 'three',
            -4 => 'four',
            -5 => 'five',
            -6 => 'six',
            -7 => 'seven',
            -8 => 'eight',
            -9 => 'nine',
            -10 => 'ten',
            0 => 'zero',
            1 => 'one',
            2 => 'two',
            3 => 'three',
            4 => 'four',
            5 => 'five',
            6 => 'six',
            7 => 'seven',
            8 => 'eight',
            9 => 'nine',
            10 => 'ten',
        ];

        private $name1;
        private $name2;

        private $age1;
        private $age2;

        private $years;

        private $ran;

        private $expression;

        private $blurb = [];

        function __construct(){
            $this->Question();
            $this->Answer();
        }

        function generateBlurb(){
            $years = (abs($this->age1 - $this->age2)==1 ? 'year':'years');
            if($this->age1 - $this->age2 < 0){
                $this->blurb[] = '\mathrm{'.$this->name1.' \ is \ '.$this->numberDictionary[$this->age1].' \ years \ old. \ '.$this->name2.' \ is \ '.$this->numberDictionary[$this->age2-$this->age1].' \ '.$years.' \ older \ than \ '.$this->name1.'.}';
            } else if ($this->age1 - $this->age2 > 0){
                $this->blurb[] = '\mathrm{'.$this->name1.' \ is \ '.$this->numberDictionary[$this->age1].' \ years \ old. \ '.$this->name2.' \ is \ '.$this->numberDictionary[$this->age2-$this->age1].' \ '.$years.' \ younger \ than \ '.$this->name1.'.}';
            } else {
                $this->blurb[] = '\mathrm{'.$this->name1.' \ and \ '.$this->name2.' \ are \ both \ '.$this->age1.' \ years \ old.}';
            }
            $this->blurb[] = '\mathrm{After \ a \ number \ of \ years \ the \ product \ of \ '.$this->name1."'s \ and \ ".$this->name2."'s \ ages \ is \ ".(($this->age1 + $this->years)*($this->age2 + $this->years)).'}';
        }

        function chooseNames(){
            $ran1 = random_int(0, count($this->names1)-1);
            $ran2 = random_int(0, count($this->names2)-1);

            $this->name1 = $this->names1[$ran1];
            $this->name2 = $this->names2[$ran2];
        }

        function generateYears(){
            $this->years = random_int(1,4);
        }

        function generateAges(){
            $this->age1 = random_int(2,9);
            $this->age2 = random_int(2,9);
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
            $this->generateAges();
            $this->generateYears();
            $this->chooseNames();
            $this->generateBlurb();
            $this->question = '\mathrm{Determine \ the \ number \ of \ years}';
        }

        function Answer()
        {
            $this->answer = $this->years;
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
?>
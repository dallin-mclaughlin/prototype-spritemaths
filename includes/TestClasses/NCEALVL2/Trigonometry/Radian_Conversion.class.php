<?php

    class RadianConversion extends Question{
        
        private $answer;
        private $question;

        private $rad;
        private $degrees;


        private $blurb = ["\mathrm{ Give \ your \ answer \ in \ exact \ form \ without \ units}"];

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
            $ran = random_int(0,1);
            if($ran){   
                //Convert degrees into rad
                $this->degrees = random_int(1,360);
                $this->rad = $this->degrees * pi() / 180;
                $this->answer = $this->rad;
                $this->question = '\mathrm{ Convert \ } '.$this->degrees.'^{\circ} \ \mathrm{ into \ radians}';
            } else {
                $ran_pi = random_int(0,1);
                if($ran_pi){
                    //Convert rad into degrees (get pi in here)
                    $this->rad = round(random_int(1,100)*2*pi()/100,2);
                    $this->degrees = $this->rad * (180 / pi());
                    $this->answer = $this->degrees;
                    $this->question = '\mathrm{ Convert \ } '.$this->rad.'\mathrm{ \ rad \ into \ degrees}';
                } else {
                    $numerator = random_int(1,5);
                    $denominator = random_int(2,7);
                    $this->rad = $numerator/$denominator*pi();
                    $this->degrees = $this->rad * (180 / pi());
                    $this->answer = $this->degrees;
                    $this->question = '\mathrm{ Convert \ } \frac{'.$numerator.'}{'.$denominator.'}\pi \mathrm{ \ rad \ into \ degrees}';
                }
            }
        }

        function Answer(){

        }


        function getQuestion(){
            return $this->question;
        }

        function getAnswer(){
            return $this->answer;
        }
    }
?>
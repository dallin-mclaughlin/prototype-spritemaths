<?php

    class OrderingNumbersQuestion extends Question{

        function __construct(){
            $range = 100;
            $symbols = ['=','<','>'];

            $number1 = random_int(-$range, $range);
            $number2 = random_int(-$range, $range);

            $ran = random_int(0,count($symbols)-1);
            $symbol = $symbols[$ran];

            $relation = $number1.$symbol.$number2;

            $this->addToBlurb('\mathrm{ Type \ capital \ T \ or \ capital \ F \ to \ indicate \ your \ choice}');
            $this->setQuestion('\mathrm{State \ whether \ this \ statement \ is \ True \ or \ False \ } '.$relation);
            $this->setAnswer($this->determineTruth($ran, $number1, $number2));
        }

        function determineTruth($ran, $num1, $num2)
        {
            if($ran===0)
            {
                if($num1 == $num2) 
                {
                    return 'T';
                } else 
                {
                    return 'F';
                }
            } else if($ran===1)
            {
                if($num1 < $num2) 
                {
                    return 'T';
                } else 
                {
                    return 'F';
                }
            } else if($ran===2)
            {
                if($num1 > $num2) 
                {
                    return 'T';
                } else 
                {
                    return 'F';
                }
            }
        }
    }

?>
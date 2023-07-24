<?php

    class LowestCommonMultipleQuestion extends Question{

        function __construct(){
            $a = random_int(1,15);
            $b = random_int(1,15);

            $this->setQuestion('\mathrm{Find \ the \ lowest \ common \ multiple \ of \ }'.
                                $a.'\mathrm{ \ and \ }'.$b);
            $this->setAnswer($this->lowestCommonMultiple($a, $b));
       }

       function lowestCommonMultiple($num1, $num2)
       {
           $num1Multiples = [];
           $num2Multiples = [];
           for($i = 1; $i < 15; $i++)
           {
                array_push($num1Multiples, $i * $num1);
                array_push($num2Multiples, $i * $num2);
           }

           $sameMultiples = array_intersect($num1Multiples, $num2Multiples);
           return min($sameMultiples);
       }
       
    }

?>
<?php

    class HighestCommonFactorQuestion extends Question{

       function __construct(){
            $factor = random_int(1,12);
            $a = random_int(1,12);
            $b = random_int(1,12);

            $num1 = $a * $factor;
            $num2 = $b * $factor;

            $this->setQuestion('\mathrm{ Find \ the \ highest \ common \ factor \ of \ }'.
                                ($num1).'\mathrm{ \ and \ }'.
                                ($num2));
            $this->setAnswer($this->highestCommonFactor($num1, $num2));
       }

       function highestCommonFactor($num1, $num2)
       {
           $biggerNum = max($num1, $num2);
           for($i = $biggerNum; $i > 0; $i--)
           {
               if($num1%$i==0 && $num2%$i==0){
                   return $i;
               }
           }
       }
    }

?>
<?php

    class MaximaMinima extends Question{   
        private $range = [];
        private $type = '';
        
        function __construct(){
            $this->maxmin();
        }

        function maxmin(){
            //y = (x + a)(x + b)
            //y = x^2 + cx + d
            $a = (random_int(0,1))?random_int(1,12):-random_int(1,12);
            $b = (random_int(0,1))?random_int(1,12):-random_int(1,12);
            $midX = ($a + $b)/2;
            $c = $a + $b;
            $d = $a * $b;
            //Make either +ve or -ve parabola
            if(random_int(0,1)){
                //+ve
                $equation = 'x^2+'.$c.'x+'.$d;
                $equation = str_replace("+-","-", $equation);
                $answer = pow($midX, 2) + $c * $midX + $d;
                $this->setAnswer($answer);
                $this->setQuestion('\mathrm{ Determine \ the \ minimum \ } y \mathrm{ \ value \ of \ the \ graph \ } \ y='.$equation);

            } else {
                $equation = '-x^2+'.(-$c).'x+'.(-$d);
                $equation = str_replace("+-","-", $equation);
                $answer = -(pow($midX, 2) + $c * $midX + $d);
                $this->setAnswer($answer);
                $this->setQuestion('\mathrm{ Determine \ the \ maximum \ } y \mathrm{ \ value \ of \ the \ graph \ } \ y='.$equation);
            }

        }
        
    }

?>


//this gives wrong answers i have no idea why at present


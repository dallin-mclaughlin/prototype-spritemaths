<?php

    class Intercepts extends Question{   
        private $range = [];
        private $type = '';
        
        function __construct(){
            $graphs = ['xaxis','yaxis','twolines','twoquads','linequad'];

            $graph = $graphs[array_rand($graphs)];
            $graph = 'yaxis';

            if($graph == 'xaxis'){
                $this->xaxis();
            } else if($graph == 'yaxis'){
                $this->yaxis();
            } else if($graph == 'twolines'){
                $this->twolines();
            } else if($graph == 'twoquads'){
                $this->twoquads();
            } else if($graph == 'linequad'){
                $this->linequad();
            }
        }

        function xaxis(){
            //line or parabola interects?
            if(random_int(0,1)){
                //line
                $a = (random_int(0,1))?random_int(2,15):-random_int(2,15);
                $b = (random_int(0,1))?random_int(2,9):-random_int(2,9);
                $equation = 'y='.$a.'x+'.$b;
                $equation = str_replace("+-","-", $equation);
                $this->setAnswer(-$b/$a);
                $this->setQuestion('\mathrm{ Determine \ the \ } x \mathrm{ \ value \ where \ the \ graph \ } \ '.$equation.' \mathrm{ \ intercepts \ the \ } x \mathrm{ -axis}');
            } else {
                 //parabola y = (x + a)(x + b)
                 $a = (random_int(0,1))?random_int(2,9):-random_int(2,9);
                 $b = (random_int(0,1))?random_int(2,9):-random_int(2,9);
                 $equation = 'y=x^2+'.($a+$b).'x+'.($a*$b);
                 $equation = str_replace("+-","-", $equation);
                 $this->setAnswer((-$a).','.(-$b));
                 $this->setQuestion('\mathrm{ Determine \ the \ } x \mathrm{ \ values \ where \ the \ graph \ } \ '.$equation.' \mathrm{ \ intercepts \ the \ } x \mathrm{ -axis}');
            }

        }

        function yaxis(){
            //line or parabola interects?
            if(random_int(0,1)){
                //line
                $a = (random_int(0,1))?random_int(2,15):-random_int(2,15);
                $b = (random_int(0,1))?random_int(2,9):-random_int(2,9);
                $equation = 'y='.$a.'x+'.$b;
                $equation = str_replace("+-","-", $equation);
                $this->setAnswer($b);
                $this->setQuestion('\mathrm{ Determine \ the \ } y \mathrm{ \ value \ where \ the \ graph \ } \ '.$equation.' \mathrm{ \ intercepts \ the \ } y \mathrm{ -axis}');
            } else {
                 //parabola y = (x + a)(x + b)
                 $a = (random_int(0,1))?random_int(2,9):-random_int(2,9);
                 $b = (random_int(0,1))?random_int(2,9):-random_int(2,9);
                 $equation = 'y=x^2+'.($a+$b).'x+'.($a*$b);
                 $equation = str_replace("+-","-", $equation);
                 $this->setAnswer($a*$b);
                 $this->setQuestion('\mathrm{ Determine \ the \ } y \mathrm{ \ value \ where \ the \ graph \ } \ '.$equation.' \mathrm{ \ intercepts \ the \ } y \mathrm{ -axis}');
            }
        }

        function twolines(){

        }

        function twoquads(){

        }

        function linequad(){

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


<?php

    class ComplexArithmetic extends Question{   
        
        function __construct(){
            $arithmetics = ['add','subtract','multiply','divide','power'];

            $arithmetic = $arithmetics[array_rand($arithmetics)];

            if($arithmetic == 'add'){
                $this->add();
            } else if($arithmetic == 'subtract'){
                $this->subtract();
            } else if($arithmetic == 'multiply'){
                $this->multiply();
            } else if($arithmetic == 'divide'){
                $this->divide();
            } else if($arithmetic == 'power'){
                $this->power();
            }
        }

        function add(){
            //(a+bi) + (c+di)
            $a = (random_int(0,1))?random_int(1,12):-random_int(1,12);
            $b = (random_int(0,1))?random_int(1,12):-random_int(1,12);
            $c = (random_int(0,1))?random_int(1,12):-random_int(1,12);
            $d = (random_int(0,1))?random_int(1,12):-random_int(1,12);

            $expression = '\left('.$this->formatComplexExpression($a,$b).'\right)+\left('.$this->formatComplexExpression($c,$d).'\right)';
            $expression = str_replace('+-','-',$expression);

            $real = ($a + $c);
            $imag = ($b + $d);

            $answerExpression = $this->formatComplexExpression($real, $imag);
            $answerExpression = str_replace('+-','-',$answerExpression);

            $this->addToBlurb('\mathrm{Rewrite \ into \ the \ form \ } a+bi');
            $this->setQuestion($expression);
            $this->setAnswer($answerExpression);
        }

        function subtract(){
            //(a+bi) + (c+di)
            $a = (random_int(0,1))?random_int(1,12):-random_int(1,12);
            $b = (random_int(0,1))?random_int(1,12):-random_int(1,12);
            $c = (random_int(0,1))?random_int(1,12):-random_int(1,12);
            $d = (random_int(0,1))?random_int(1,12):-random_int(1,12);

            $expression = '\left('.$this->formatComplexExpression($a,$b).'\right)-\left('.$this->formatComplexExpression($c,$d).'\right)';
            $expression = str_replace('+-','-',$expression);

            $real = ($a - $c);
            $imag = ($b - $d);

            $answerExpression = $this->formatComplexExpression($real, $imag);
            $answerExpression = str_replace('+-','-',$answerExpression);

            $this->addToBlurb('\mathrm{Rewrite \ into \ the \ form \ } a+bi');
            $this->setQuestion($expression);
            $this->setAnswer($answerExpression);
        }

        function multiply(){
            $type = random_int(0,2);
            if($type == 0){
                //(a+bi)(c+di)
                $a = (random_int(0,1))?random_int(1,12):-random_int(1,12);
                $b = (random_int(0,1))?random_int(1,12):-random_int(1,12);
                $c = (random_int(0,1))?random_int(1,12):-random_int(1,12);
                $d = (random_int(0,1))?random_int(1,12):-random_int(1,12);

                $expression = '\left('.$this->formatComplexExpression($a,$b).'\right)\left('.$this->formatComplexExpression($c,$d).'\right)';
                $expression = str_replace('+-','-',$expression);

                $real = ($a*$c - $b*$d);
                $imag = ($a*$d + $b*$c);

                $answerExpression = $this->formatComplexExpression($real, $imag);
                $answerExpression = str_replace('+-','-',$answerExpression);

                $this->addToBlurb('\mathrm{Rewrite \ into \ the \ form \ } a+bi');
                $this->setQuestion($expression);
                $this->setAnswer($answerExpression);
            } else if($type == 1){
                //a(c+di)
                $a = (random_int(0,1))?random_int(1,12):-random_int(1,12);
                $b = 0;
                $c = (random_int(0,1))?random_int(1,12):-random_int(1,12);
                $d = (random_int(0,1))?random_int(1,12):-random_int(1,12);

                $expression = $a.'\left('.$this->formatComplexExpression($c, $d).'\right)';
                $expression = str_replace('+-','-',$expression);

                $real = ($a*$c);
                $imag = ($a*$d);

                $this->addToBlurb('\mathrm{Rewrite \ into \ the \ form \ } a+bi');
                $this->setQuestion($expression);

                $answerExpression = $this->formatComplexExpression($real, $imag);
                $answerExpression = str_replace('+-','-',$answerExpression);

                $this->setQuestion('\mathrm{ Evaluate \ }'.$expression);
                $this->setAnswer($answerExpression);
            } else if($type == 2){
                //bi(c+di)
                $a = 0;
                $b = (random_int(0,1))?random_int(1,12):-random_int(1,12);
                $c = (random_int(0,1))?random_int(1,12):-random_int(1,12);
                $d = (random_int(0,1))?random_int(1,12):-random_int(1,12);

                $expression = $b.'i\left('.$this->formatComplexExpression($c, $d).'\right)';
                $expression = str_replace('+-','-',$expression);

                $real = (-$b*$d);
                $imag = ($b*$c);

                $answerExpression = $this->formatComplexExpression($real, $imag);
                $answerExpression = str_replace('+-','-',$answerExpression);

                $this->addToBlurb('\mathrm{Rewrite \ into \ the \ form \ } a+bi');
                $this->setQuestion($expression);
                $this->setAnswer($answerExpression);
            }
        }

        function divide(){
            $type = random_int(0,5);
            $type = 5;
            if($type == 0){
                //(a+bi)/(c+di)
                $a = (random_int(0,1))?random_int(1,6):-random_int(1,6);
                $b = (random_int(0,1))?random_int(1,6):-random_int(1,6);
                $c = (random_int(0,1))?random_int(1,6):-random_int(1,6);
                $d = (random_int(0,1))?random_int(1,6):-random_int(1,6);

                $expression = '\frac{\left('.$this->formatComplexExpression($a,$b).'\right)}{\left('.$this->formatComplexExpression($c,$d).'\right)}';
                $expression = str_replace('+-','-',$expression);

                $denominator = pow($c,2)+pow($d,2);
                $real = ($a*$c + $b*$d)/($denominator);
                $imag = ($b*$c - $a*$d)/($denominator);

                $answerExpression = $this->formatComplexExpression($real, $imag);
                $answerExpression = str_replace('+-','-',$answerExpression);

                $this->addToBlurb('\mathrm{Rewrite \ into \ the \ form \ } a+bi');
                $this->setQuestion($expression);
                $this->setAnswer($answerExpression);
            } else if($type == 1){
                //a/(c+di)
                $a = (random_int(0,1))?random_int(1,12):-random_int(1,12);
                $b = 0;
                $c = (random_int(0,1))?random_int(1,12):-random_int(1,12);
                $d = (random_int(0,1))?random_int(1,12):-random_int(1,12);

                $expression = '\frac{'.$a.'}{\left('.$this->formatComplexExpression($c, $d).'\right)}';
                $expression = str_replace('+-','-',$expression);

                $denominator = pow($c,2)+pow($d,2);
                $real = ($a*$c)/$denominator;
                $imag = -($a*$d)/$denominator;

                $answerExpression = $this->formatComplexExpression($real, $imag);
                $answerExpression = str_replace('+-','-',$answerExpression);

                $this->addToBlurb('\mathrm{Rewrite \ into \ the \ form \ } a+bi');
                $this->setQuestion($expression);
                $this->setAnswer($answerExpression);
            } else if($type == 2){
                //bi/(c+di)
                $a = 0;
                $b = (random_int(0,1))?random_int(1,12):-random_int(1,12);
                $c = (random_int(0,1))?random_int(1,12):-random_int(1,12);
                $d = (random_int(0,1))?random_int(1,12):-random_int(1,12);

                $expression = '\frac{'.$this->formatComplexExpression(0, $b).'}{\left('.$this->formatComplexExpression($c, $d).'\right)}';
                $expression = str_replace('+-','-',$expression);

                $denominator = pow($c,2)+pow($d,2);
                $real = ($b*$d)/$denominator;
                $imag = ($b*$c)/$denominator;

                $answerExpression = $this->formatComplexExpression($real, $imag);
                $answerExpression = str_replace('+-','-',$answerExpression);

                $this->addToBlurb('\mathrm{Rewrite \ into \ the \ form \ } a+bi');
                $this->setQuestion($expression);
                $this->setAnswer($answerExpression);
            } else if($type == 3){
                //(a+bi)/c
                $a = (random_int(0,1))?random_int(1,12):-random_int(1,12);
                $b = (random_int(0,1))?random_int(1,12):-random_int(1,12);
                $c = (random_int(0,1))?random_int(1,12):-random_int(1,12);
                $d = 0;

                $expression = '\frac{'.$this->formatComplexExpression($a, $b).'}{'.$this->formatComplexExpression($c, 0).'}';
                $expression = str_replace('+-','-',$expression);

                $denominator = $c;
                $real = ($a)/$denominator;
                $imag = ($b)/$denominator;

                $answerExpression = $this->formatComplexExpression($real, $imag);
                $answerExpression = str_replace('+-','-',$answerExpression);

                $this->addToBlurb('\mathrm{Rewrite \ into \ the \ form \ } a+bi');
                $this->setQuestion($expression);
                $this->setAnswer($answerExpression);
            } else if($type == 4){
                //(a+bi)/di
                $a = (random_int(0,1))?random_int(1,12):-random_int(1,12);
                $b = (random_int(0,1))?random_int(1,12):-random_int(1,12);
                $c = 0;
                $d = (random_int(0,1))?random_int(1,12):-random_int(1,12);

                $expression = '\frac{'.$this->formatComplexExpression($a, $b).'}{'.$this->formatComplexExpression(0, $d).'}';
                $expression = str_replace('+-','-',$expression);

                $denominator = $d;
                $real = ($b)/$denominator;
                $imag = -($a)/$denominator;

                $answerExpression = $this->formatComplexExpression($real, $imag);
                $answerExpression = str_replace('+-','-',$answerExpression);

                $this->addToBlurb('\mathrm{Rewrite \ into \ the \ form \ } a+bi');
                $this->setQuestion($expression);
                $this->setAnswer($answerExpression);
            } else if($type == 5){
                echo '5';
                //(bi)/di
                $a = 0;
                $b = (random_int(0,1))?random_int(1,12):-random_int(1,12);
                $c = 0;
                $d = (random_int(0,1))?random_int(1,12):-random_int(1,12);

                $expression = '\frac{'.$this->formatComplexExpression($a, $b).'}{'.$this->formatComplexExpression($c, $d).'}';
                $expression = str_replace('+-','-',$expression);

                $real = ($b)/($d);
                $imag = 0;

                $answerExpression = $this->formatComplexExpression($real, $imag);
                $answerExpression = str_replace('+-','-',$answerExpression);

                $this->addToBlurb('\mathrm{Rewrite \ into \ the \ form \ } a+bi');
                $this->setQuestion($expression);
                $this->setAnswer($answerExpression);
            }

        }

        function power(){
            //(a+bi)^(2 or 3)
            $power = random_int(2,3);
            $a = (random_int(0,1))?random_int(1,12):-random_int(1,12);
            $b = (random_int(0,1))?random_int(1,12):-random_int(1,12);

            $expression = '\left('.$this->formatComplexExpression($a, $b).'\right)^'.$power;
            $expression = str_replace('+-','-',$expression);

            $real = 0;
            $imag = 0;
            if($power == 2){
                $real = (pow($a,2) - pow($b,2));
                $imag = 2*$a*$b;
            } else if($power == 3){
                $real = pow($a,3)-3*$a*pow($b,2);
                $imag = 3*pow($a,2)*$b-pow($b,3);
            }
            $answerExpression = $this->formatComplexExpression($real, $imag);
            $answerExpression = str_replace('+-','-',$answerExpression);

            $this->addToBlurb('\mathrm{Rewrite \ into \ the \ form \ } a+bi');
            $this->setQuestion($expression);
            $this->setAnswer($answerExpression);
        }

        function formatComplexExpression($real, $imag){
            if($real === 0 && $imag === 0){
                return '';
            } else if($real === 0 && $imag !== 0){
                if($imag === 1){
                    return 'i';
                } else if($imag === -1){
                    return '-i';
                } else {
                    return $imag.'i';
                }
            } else if($real !== 0 && $imag === 0){
                return $this->float2rat($real);
            } else if($real !== 0 && $imag !== 0){
                if($imag === 1){
                    return $this->float2rat($real).'+i';
                } else if($imag === -1){
                    return $this->float2rat($real).'-i';
                } else {
                    return $this->float2rat($real).'+'.$this->float2rat($imag).'i';
                }
            }
        }

        
    }

?>



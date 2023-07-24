<?php

    class ComplexRoots extends Question{   
        
        function __construct(){
            $roots = ['real','complex'];

            $root = $roots[array_rand($roots)];

            $root = 'real';
            if($root == 'real'){
                $this->real();
            } else if($root == 'complex'){
                $this->complex();
            }
        }

        function real(){
            //ax^2 + bx + c; c > b^2/(4a)
            $a = (random_int(0,1))?random_int(1,3):-random_int(1,3);
            $b = (random_int(0,1))?random_int(1,12):-random_int(1,12);

            if($a < 0){
                $c = ceil(pow($b,2)/(4*$a)) + random_int(1,10);
            } else if($a > 0){
                $c = floor(pow($b,2)/(4*$a)) - random_int(1,10);
            }
            if($a != 1){
                if($b != 1){
                    $expression = $a.'x^2+'.$b.'x+'.$c;
                } else {
                    $expression = $a.'x^2+x+'.$c;
                }
            } else {
                if($b != 1){
                    $expression = 'x^2+'.$b.'x+'.$c;
                } else {
                    $expression = 'x^2+x+'.$c;
                }
            }
            $expression = str_replace('+-','-',$expression);

            $answerExpression = ($this->getTerm($a,$b).'+'.$this->getTerm($a,$b,$c).','
                                    .$this->getTerm($a,$b).'-'.$this->getTerm($a,$b,$c));
            $answerExpression = str_replace('+-','-',$answerExpression);
            $answerExpression = str_replace('--','+',$answerExpression);

            $this->addToBlurb('\mathrm{Determine \ the  \ roots \ of \ the \ expression }');
            $this->setQuestion($expression);
            $this->setAnswer($answerExpression);
        }

        function complex(){
            //ax^2 + bx + c; c > b^2/(4a)
            $a = (random_int(0,1))?random_int(1,3):-random_int(1,3);
            $b = (random_int(0,1))?random_int(1,12):-random_int(1,12);

            if($a < 0){
                $c = floor(pow($b,2)/(4*$a)) - random_int(1,10);
            } else if($a > 0){
                $c = ceil(pow($b,2)/(4*$a)) + random_int(1,10);
            }
            if($a != 1){
                if($b != 1){
                    $expression = $a.'x^2+'.$b.'x+'.$c;
                } else {
                    $expression = $a.'x^2+x+'.$c;
                }
            } else {
                if($b != 1){
                    $expression = 'x^2+'.$b.'x+'.$c;
                } else {
                    $expression = 'x^2+x+'.$c;
                }
            }
            $expression = str_replace('+-','-',$expression);

            $answerExpression = ($this->getTerm($a,$b).'+'.$this->getTerm($a,$b,$c).','
                                    .$this->getTerm($a,$b).'-'.$this->getTerm($a,$b,$c));
            $answerExpression = str_replace('+-','-',$answerExpression);
            $answerExpression = str_replace('--','+',$answerExpression);

            $this->addToBlurb('\mathrm{Determine \ the  \ roots \ of \ the \ expression }');
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

        function getSquareRoot($num){
            $negative = false;
            if($num < 0){
                $negative = true;
            }
            $absoluteNum = abs($num);
            $squares = [1,4,9,16,25,36,49,64,81,100,121,144,169,196,225,256,289,324,361,400,
                        441,484,529,576,625];
            if(in_array($absoluteNum,$squares)){
                if($negative){
                    return sqrt(-$num);
                } else {
                    return sqrt($num);
                }
            } else {
                if($negative){
                    return '\sqrt{'.(-$num).'}';
                } else {
                    return '\sqrt{'.$num.'}';
                }
            }
        }

        function getTerm($a, $b, $c = 0){
            if($c === 0){
                return $this->float2rat(-$b/(2*$a));
            }

            $secondTerm = pow($b, 2)-4*$a*$c;
            if($secondTerm < 0){
                if($a < 0){
                    return '-\frac{'.$this->getSquareRoot($secondTerm).'}{'.(2*(-$a)).'}i';
                } else if($a > 0){
                    return '\frac{'.$this->getSquareRoot($secondTerm).'}{'.(2*$a).'}i';
                }
            } else if($secondTerm > 0){
                if($a < 0){
                    return '-\frac{'.$this->getSquareRoot($secondTerm).'}{'.(2*(-$a)).'}';
                } else if($a > 0){
                    return '\frac{'.$this->getSquareRoot($secondTerm).'}{'.(2*$a).'}';
                }
            }
        }

        
    }

?>



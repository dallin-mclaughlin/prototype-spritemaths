<?php

    class RectangularPolar extends Question{   
        
        function __construct(){
            $types = ['rect_to_polar','polar_to_rect','rect_to_exp','exp_to_rect'];

            $type = $types[array_rand($types)];
            $type = 'exp_to_rect';
            if($type == 'rect_to_polar'){
                $this->rectToPolar();
            } else if($type == 'polar_to_rect'){
                $this->polarToRect();
            } else if($type == 'rect_to_exp'){
                $this->rectToExp();
            } else if($type == 'exp_to_rect'){
                $this->expToRect();
            }
        }

        function rectToPolar(){
            //a + bi => r(cos(theta) + isin(theta))
            $a = (random_int(0,1))?random_int(1,12):-random_int(1,12);
            $b = (random_int(0,1))?random_int(1,12):-random_int(1,12);

            $angle = atan(abs($b)/abs($a));
            $angle = round($angle, 2);
            if($a < 0 && $b > 0){
                $angle = pi() - $angle;
            } else if($a < 0 && $b < 0){
                $angle = $angle + pi();
            } else if($a > 0 && $b < 0){
                $angle = 2*pi() - $angle;
            }
            $angle = round($angle, 2);

            $r = pow($a,2)+pow($b,2);
            $expression = $a.'+'.$b.'i';
            $expression = str_replace('+-','-',$expression);

            $answerExpression = $a.'+'.$b.'i';
            $answerExpression = $this->getSquareRoot($r).'\left(cos('.$angle.')+isin('.$angle.')\right)';
            $answerExpression = str_replace('+-','-',$answerExpression);
            $answerExpression = str_replace('--','+',$answerExpression);

            $this->addToBlurb('\mathrm{Round \ radian \ angles \ to \ 2 \ d.p. }');
            $this->addToBlurb('\mathrm{Write \ the \ following \ expression \ in \ polar \ coordinates \ i.e. \ } r\left(cos(\theta)+isin(\theta)\right)');
            $this->setQuestion($expression);
            $this->setAnswer($answerExpression);
        }

        function polarToRect(){
            //r(cos(theta)+isin(theta)) => a + bi
            $r = random_int(2,49);
            $theta = random_int(0,628)/100;

            $x = round($r*cos($theta),2);
            $y = round($r*sin($theta),2);
            
            $expression = $r.'\left(cos('.$theta.')+isin('.$theta.')\right)';
            $expression = str_replace('+-','-',$expression);

            $answerExpression = $x.'+'.$y.'i';
            $answerExpression = str_replace('+-','-',$answerExpression);

            $this->addToBlurb('\mathrm{Round \ values \ to \ 2 \ d.p. }');
            $this->addToBlurb('\mathrm{Write \ the \ following \ expression \ in \ rectangular \ coordinates \ i.e. \ } x+yi');
            $this->setQuestion($expression);
            $this->setAnswer($answerExpression);
        }

        function rectToExp(){
            //a + bi => rexp(theta*i))
            $a = (random_int(0,1))?random_int(1,12):-random_int(1,12);
            $b = (random_int(0,1))?random_int(1,12):-random_int(1,12);

            $angle = atan(abs($b)/abs($a));
            $angle = round($angle, 2);
            if($a < 0 && $b > 0){
                $angle = pi() - $angle;
            } else if($a < 0 && $b < 0){
                $angle = $angle + pi();
            } else if($a > 0 && $b < 0){
                $angle = 2*pi() - $angle;
            }
            $angle = round($angle, 2);

            $r = pow($a,2)+pow($b,2);
            $expression = $a.'+'.$b.'i';
            $expression = str_replace('+-','-',$expression);

            $answerExpression = $a.'+'.$b.'i';
            $answerExpression = $this->getSquareRoot($r).'e^{'.$angle.'i}';
            $answerExpression = str_replace('+-','-',$answerExpression);
            $answerExpression = str_replace('--','+',$answerExpression);

            $this->addToBlurb('\mathrm{Round \ radian \ angles \ to \ 2 \ d.p. }');
            $this->addToBlurb('\mathrm{Write \ the \ following \ expression \ in \ exponential \ form \ i.e. \ } re^{\theta i}');
            $this->setQuestion($expression);
            $this->setAnswer($answerExpression);
        }

        function expToRect(){
            //rexp(theta*i)) => a + bi
            $r = random_int(2,49);
            $theta = random_int(0,628)/100;

            $x = round($r*cos($theta),2);
            $y = round($r*sin($theta),2);
            
            $expression = $r.'e^{'.$theta.'i}';
            $expression = str_replace('+-','-',$expression);

            $answerExpression = $x.'+'.$y.'i';
            $answerExpression = str_replace('+-','-',$answerExpression);

            $this->addToBlurb('\mathrm{Round \ values \ to \ 2 \ d.p. }');
            $this->addToBlurb('\mathrm{Write \ the \ following \ expression \ in \ rectangular \ coordinates \ i.e. \ } x+yi');
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

        
    }

?>



<?php

    class DemoivresTheorem extends Question{   
        
        function __construct(){
            $types = ['power','root'];

            $type = $types[array_rand($types)];
            if($type == 'power'){
                $this->power();
            } else if($type == 'root'){
                $this->root();
            }
        }

        function power(){
            $power = random_int(2,4);
            $r = random_int(2,15);
            $angle = random_int(0,628)/100;
            $questionExpression = '['.$r.'\left(cos('.$angle.')+isin('.$angle.')\right)]^{'.$power.'}';

            $answerExpression = pow($r,$power).'\left(cos('.($angle*$power).')+isin('.($angle*$power).')\right)';
            $this->addToBlurb('\mathrm{Round \ radian \ angles \ to \ 2 \ d.p. }');
            $this->addToBlurb('\mathrm{Write \ the \ following \ expression \ in \ polar \ coordinates \ i.e. \ } r\left(cos(\theta)+isin(\theta)\right)');
            $this->setQuestion($questionExpression);
            $this->setAnswer($answerExpression);
        }

        function root(){
            $root = random_int(2,4);
            $r = random_int(2,15);
            $angle = random_int(0,628)/100;
            $questionExpression = '['.$r.'\left(cos('.$angle.')+isin('.$angle.')\right)]^{\frac{1}{'.$root.'}}';

            $answerExpression = pow($r,1/$root).'\left(cos('.round($angle/$root,2).')+isin('.round($angle/$root,2).')\right)';
            $this->addToBlurb('\mathrm{Round \ radian \ angles \ to \ 2 \ d.p. }');
            $this->addToBlurb('\mathrm{Write \ the \ following \ expression \ in \ polar \ coordinates \ i.e. \ } r\left(cos(\theta)+isin(\theta)\right)');
            $this->setQuestion($questionExpression);
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



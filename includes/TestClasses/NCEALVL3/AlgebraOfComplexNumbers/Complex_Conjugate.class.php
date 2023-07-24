<?php

    class ComplexConjugate extends Question{   
        
        function __construct(){
            $x = (random_int(0,1))?random_int(1,12):-random_int(1,12);
            $y = (random_int(0,1))?random_int(1,12):-random_int(1,12);

            $questionExpression = $this->formatComplexExpression($x,$y);
            $questionExpression = str_replace('+-','-',$questionExpression);
            $answerExpression = $this->formatComplexExpression($x,-$y);
            $answerExpression = str_replace('+-','-',$answerExpression);

            $this->addToBlurb('\mathrm{Determine \ the \ complex \ conjugate}');
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

        

        
    }

?>



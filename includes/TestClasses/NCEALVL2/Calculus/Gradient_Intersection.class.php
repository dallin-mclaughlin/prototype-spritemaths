<?php

    class GradientIntersection extends Question{   
        
        function __construct(){
            $x_0 = random_int(-2,2);
            $variable = 'x';
            $degree = random_int(2,2);
            $coefficients = [];
            $difCoefficients = [];
            for($i = 0; $i <= $degree; $i++){
                $coeff = (random_int(0,1))?random_int(1,7):-random_int(1,7);
                array_push($coefficients, $coeff);
            }
            //Make sure not zero at the start
            /* $zero = true;
            foreach($coeffArray as $coeff){
                if($coeff!=0){
                    $zero =  false;
                    break;
                }
            }
            if($zero){
                return '0';
            } */
            for($i = 0; $i < count($coefficients)-1; $i++){
                array_push($difCoefficients, $coefficients[$i]*(count($coefficients)-1-$i));
            }
            $polyExpression = $this->generatePoly($coefficients, $variable);
            $polyExpression = str_replace('+-','-',$polyExpression);

            $m = $difCoefficients[0]*$x_0+$difCoefficients[1];

            $this->addToBlurb('\mathrm{Find \ the \ } x- \mathrm{ coordinate \ when \ the \ gradient \ is \ }'.$m);
            $this->setQuestion('y='.$polyExpression);
            $this->setAnswer($x_0);
        }

        function generatePoly($coeffArray, $variable){
            $zero = true;
            foreach($coeffArray as $coeff){
                if($coeff!=0){
                    $zero =  false;
                    break;
                }
            }
            if($zero){
                return '0';
            }
            $poly = '';
            for($i = 0; $i < count($coeffArray); $i++){
                $coeff = $coeffArray[$i];
                if($coeff==0)continue;
                $power = count($coeffArray) - 1 - $i;
                if($power == 1){
                    if($coeff != 1 && $coeff != -1){
                        $poly .= $coeff.$variable;
                    } else {
                        if($coeff == 1){
                            $poly .= $variable;
                        } else if($coeff == -1){
                            $poly .= '-'.$variable;
                        }
                    }
                } else if($power != 0){
                    if($coeff != 1 && $coeff != -1){
                        $poly .= $coeff.$variable.'^{'.$power.'}';
                    } else {
                        if($coeff == 1){
                            $poly .= $variable.'^{'.$power.'}';
                        } else if($coeff == -1){
                            $poly .= '-'.$variable.'^{'.$power.'}';
                        }
                    }
                } else if($power == 0){
                    $poly .= $coeff;
                }
                if($i < count($coeffArray)-1){
                    $poly .= '+';
                }
            }
            if(substr($poly,-1)=='+'){
                $poly = substr($poly,0,-1);
            }
            return $poly;
        }

        
    }

?>



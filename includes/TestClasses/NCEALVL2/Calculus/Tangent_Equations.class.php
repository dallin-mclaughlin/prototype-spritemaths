<?php

    class TangentEquations extends Question{   
        
        function __construct(){
            $x_0 = random_int(-2,2);
            $variable = 'x';
            $degree = random_int(3,3);
            $coefficients = [];
            $difCoefficients = [];
            for($i = 0; $i <= $degree; $i++){
                $coeff = (random_int(0,1))?random_int(1,7):-random_int(1,7);
                $coeff = (random_int(0,2))?$coeff:0;
                array_push($coefficients, $coeff);
            }
            //Make sure there is atleast one non-zero element in there!
            if(array_sum($coefficients)==0){
                array_push($coefficients, random_int(1,9));
            }
            for($i = 0; $i < count($coefficients)-1; $i++){
                array_push($difCoefficients, $coefficients[$i]*(count($coefficients)-1-$i));
            }
            $polyExpression = $this->generatePoly($coefficients, $variable);
            $polyExpression = str_replace('+-','-',$polyExpression);

            $y_0 = $coefficients[0]*pow($x_0,3)+$coefficients[1]*pow($x_0,2)+$coefficients[2]*$x_0+$coefficients[3];
            $m = $difCoefficients[0]*pow($x_0,2)+$difCoefficients[1]*$x_0+$difCoefficients[2];
            $c = $y_0 - $m*$x_0;

            $answerExpression = 'y='.$m.'x+'.$c;
            $answerExpression = str_replace('+-','-',$answerExpression);

            $this->addToBlurb('\mathrm{Find \ the \ tangent \ equation \ for \ the \ graph \ below \ at \ the \ point \ }x='.$x_0);
            $this->setQuestion('y='.$polyExpression);
            $this->setAnswer($answerExpression);
        }

        function generatePoly($coeffArray, $variable){
            if(array_sum($coeffArray)==0){
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



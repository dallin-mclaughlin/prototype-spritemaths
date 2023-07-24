<?php

    class DistanceSpeedAcceleration extends Question{   
        
        function __construct(){
            $variable = 't';
            $time = random_int(1,9);
            $degree = random_int(2,3);
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

            $velocity = $difCoefficients[0]*$time + $difCoefficients[1];

            //echo $polyExpression;
            //echo $difExpression;

            $this->addToBlurb('\mathrm{Find \ the \ velocity \ of \ the \ object \ at \ time \ } t='.$time);
            $this->setQuestion('d(t)='.$polyExpression);
            $this->setAnswer($velocity);
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



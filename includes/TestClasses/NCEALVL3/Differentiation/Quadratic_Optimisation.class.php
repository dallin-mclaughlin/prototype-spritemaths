<?php

    class QuadraticOptimisation extends Question{   
        
        function __construct(){
            $variable = 'x';
            $degree = 2;
            $coefficients = [];
            for($i = 0; $i <= $degree; $i++){
                $coeff = (random_int(0,1))?random_int(1,7):-random_int(1,7);
                array_push($coefficients, $coeff);
            }
            $xOptimal = -$coefficients[1]/(2*$coefficients[0]);
            $yOptimal = $coefficients[0]*pow($xOptimal,2) + $coefficients[1]*$xOptimal+$coefficients[2];
            $polyExpression = $this->generatePoly($coefficients, $variable);
            $polyExpression = str_replace('+-','-',$polyExpression);

            $this->addToBlurb('\mathrm{Determine \ the \ local \ min \ or \ max \ of \ the \ graph}');
            $this->setQuestion('y='.$polyExpression);
            $this->setAnswer($this->float2rat($yOptimal));
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



<?php

    class ParametricEquations extends Question{   
        
        function __construct(){
            $variable = 't';
            $xDegree = random_int(1,3);
            $yDegree = random_int(1,3);
            $xCoefficients = [];
            $xDifCoefficients = [];
            $yCoefficients = [];
            $yDifCoefficients = [];
            for($i = 0; $i <= $xDegree; $i++){
                $xCoeff = (random_int(0,1))?random_int(1,7):-random_int(1,7);
                array_push($xCoefficients, $xCoeff);
            }
            for($i = 0; $i <= $yDegree; $i++){
                $yCoeff = (random_int(0,1))?random_int(1,7):-random_int(1,7);
                array_push($yCoefficients, $yCoeff);
            }
            for($i = 0; $i < count($xCoefficients)-1; $i++){
                array_push($xDifCoefficients, $xCoefficients[$i]*(count($xCoefficients)-1-$i));
            }
            for($i=0; $i<count($yCoefficients)-1;$i++){
                array_push($yDifCoefficients, $yCoefficients[$i]*(count($yCoefficients)-1-$i));
            }

            $xPolyExpression = $this->generatePoly($xCoefficients, $variable);
            $xDifExpression = $this->generatePoly($xDifCoefficients, $variable);
            $xPolyExpression = str_replace('+-','-',$xPolyExpression);
            $xDifExpression = str_replace('+-','-',$xDifExpression);

            $yPolyExpression = $this->generatePoly($yCoefficients, $variable);
            $yDifExpression = $this->generatePoly($yDifCoefficients, $variable);
            $yPolyExpression = str_replace('+-','-',$yPolyExpression);
            $yDifExpression = str_replace('+-','-',$yDifExpression);

            $parametricDifExpression = '\frac{'.$yDifExpression.'}{'.$xDifExpression.'}';

            $this->addToBlurb('\mathrm{Differentiate \ the \ following \ parametric \ system \ of \ equations}');
            $this->setQuestion('x(t)='.$xPolyExpression.', \ \ y(t)='.$yPolyExpression);
            $this->setAnswer($parametricDifExpression);
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



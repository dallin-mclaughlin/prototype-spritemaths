<?php

    class IntegratetoPosition extends Question{   
        
        function __construct(){
            $expressions = ['poly','expo','loge'];

            $expression = $expressions[array_rand($expressions)];

            $expression = 'poly';


            if($expression == 'poly'){
                $this->poly();
            } else if($expression == 'expo'){
                $this->expo();
            } else if($expression == 'loge'){
                $this->loge();
            }
        }

        function poly(){
            $variable = 'x';
            $degree = random_int(2,4);
            $coefficients = [];
            $difCoefficients = [];
            for($i = 0; $i <= $degree; $i++){
                $coeff = (random_int(0,1))?random_int(1,7):-random_int(1,7);
                $coeff = (random_int(0,2))?$coeff:0;
                array_push($coefficients, $coeff);
            }
            $zero = true;
            foreach($coefficients as $coeff){
                if($coeff!=0){
                    $zero =  false;
                    break;
                }
            }
            if($zero){
                array_push($coefficients, random_int(1,9));
            }
            for($i = 0; $i < count($coefficients)-1; $i++){
                array_push($difCoefficients, $coefficients[$i]*(count($coefficients)-1-$i));
            }
            $x = random_int(-3,3);
            $y = 0;
            for($i = 0; $i < count($coefficients)-1; $i++){
                $y += $coefficients[$i]*pow($x, count($coefficients)-1-$i);
            }

            $polyExpression = $this->generatePoly($coefficients, $variable);
            $difExpression = $this->generatePoly($difCoefficients, $variable);
            $polyExpression = str_replace('+-','-',$polyExpression);
            $difExpression = str_replace('+-','-',$difExpression);

            $this->addToBlurb('\mathrm{Integrate \ the \ equation \ below. \ The \ graph \ passes \ through \ the \ point } \ ('.$x.','.$y.')');
            $this->setQuestion("y'=".$difExpression);
            $this->setAnswer('y='.$polyExpression);
        }

        function expo(){
            $variable = 'x';
            $coefficient = random_int(1,9);
            $polyCoefficients = [];
            $difCoefficients = [];
            $degree = random_int(0,2);
            for($i = 0; $i <= $degree; $i++){
                $coeff = (random_int(0,1))?random_int(1,7):-random_int(1,7);
                $coeff = (random_int(0,2))?$coeff:0;
                array_push($polyCoefficients, $coeff);
            }
            $zero = true;
            foreach($polyCoefficients as $coeff){
                if($coeff!=0){
                    $zero =  false;
                    break;
                }
            }
            if($zero){
                array_push($polyCoefficients, 'x^'.random_int(1,9));
            }
            for($i = 0; $i < count($polyCoefficients)-1; $i++){
                array_push($difCoefficients, $polyCoefficients[$i]*(count($polyCoefficients)-1-$i));
            }
            $polyExpression = $this->generatePoly($polyCoefficients, $variable);
            $difExpression = $this->generatePoly($difCoefficients, $variable);
            $polyExpression = str_replace('+-','-',$polyExpression);
            $difExpression = str_replace('+-','-',$difExpression);

            $this->addToBlurb('\mathrm{Differentiate \ the \ following \ expression}');
            $this->setQuestion($coefficient.'e^{'.$polyExpression.'}');
            $this->setAnswer($coefficient.'('.$difExpression.')e^{'.$polyExpression.'}');
        }

        function loge(){
            $variable = 'x';
            $coefficient = random_int(2,9);
            $polyCoefficients = [];
            $difCoefficients = [];
            $degree = random_int(0,2);
            for($i = 0; $i <= $degree; $i++){
                $coeff = random_int(1,7);
                array_push($polyCoefficients, $coeff);
            }
            if(array_product($polyCoefficients)==0){
                array_push($polyCoefficients, 'x^'.random_int(1,9));
            }
            for($i = 0; $i < count($polyCoefficients)-1; $i++){
                array_push($difCoefficients, $polyCoefficients[$i]*(count($polyCoefficients)-1-$i));
            }
            $polyExpression = $this->generatePoly($polyCoefficients, $variable);
            $difExpression = $this->generatePoly($difCoefficients, $variable);
            $polyExpression = str_replace('+-','-',$polyExpression);
            $difExpression = str_replace('+-','-',$difExpression);

            $this->addToBlurb('\mathrm{Differentiate \ the \ following \ expression}');
            $this->setQuestion($coefficient.'ln('.$polyExpression.')');
            $this->setAnswer('\frac{'.$coefficient.'('.$difExpression.')}{'.$polyExpression.'}');
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



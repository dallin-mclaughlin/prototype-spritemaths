<?php

    class TrigIntegration extends Question{   
        
        function __construct(){
            $expressions = ['sin','cos'];

            $expression = $expressions[array_rand($expressions)];

            $expression = 'cos';
            if($expression == 'sin'){
                $this->sinInt();
            } else if($expression == 'cos'){
                $this->cosInt();
            }
        }

        function sinInt(){
            $variable = 'x';
            $multiplier = random_int(2,9);

            $difExpression = '\\int sin('.$multiplier.$variable.') \mathrm{ \ dx}';
            $intExpression = '-\frac{1}{'.$multiplier.'}cos('.$multiplier.$variable.')';

            //echo $polyExpression;
            //echo $difExpression;

            $this->addToBlurb('\mathrm{Integrate \ the \ following \ expression}');
            $this->setQuestion($difExpression);
            $this->setAnswer($intExpression);
        }

        function cosInt(){
            $variable = 'x';
            $multiplier = random_int(2,9);

            $difExpression = '\\int cos('.$multiplier.$variable.') \mathrm{ \ dx}';
            $intExpression = '\frac{1}{'.$multiplier.'}sin('.$multiplier.$variable.')';

            //echo $polyExpression;
            //echo $difExpression;

            $this->addToBlurb('\mathrm{Integrate \ the \ following \ expression}');
            $this->setQuestion($difExpression);
            $this->setAnswer($intExpression);
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



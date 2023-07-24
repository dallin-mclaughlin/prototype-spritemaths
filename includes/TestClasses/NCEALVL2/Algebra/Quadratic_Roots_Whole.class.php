<?php


//This question starts with a quadratic of the form x^2 + bx + c = 0  where n must be found
//The student is given the information that two roots exist and one of them is a multiplier
//times the other root i.e. root_2 = multiplier * root_1
//Since quadratic equations can be rewritten as (x + root_1)(x + multiplier * root_1) = 0
//expanded gives x^2 + (multiplier + 1) * root_1 * x + multiplier * root_1^2

//Figure out how to add fractions element wise
class QuadraticWholeRoots extends Question{

    private $multiplier;
    private $b;
    private $c;
    

    function __construct(){
        $ran = random_int(0,1);

        if($ran){
            $this->oneRoot();
        } else {
            $this->twoRoots();
        }
    }

    function oneRoot(){
        $root = random_int(5,100)/10;
        $root = (random_int(0,1)?-$root:$root);

        $b = -2 * $root;
        $c = pow($root,2);

        $coefficients = $this->computeCoefficients($b,$c);

        if((10 * $root) % 10 == 0){
            $this->addToBlurb('\mathrm{A \ quadratic \ has \ only \ one \ solution \ } x= '.$root);
        } else {
            $this->addToBlurb('\mathrm{A \ quadratic \ has \ only \ one \ solution \ } x= '.$this->float2rat($root));
        }
        $this->addToBlurb('\mathrm{Find \ the \ original \ quadratic \ by \ giving \ your \ answer \ 
                            in \ the \ form \ } ax^2+bx+c \mathrm{ \ where \ } a > 0, \\space b, \mathrm{ 
                            \ and \ } c \mathrm{ \ are \ }');
        $this->addToBlurb('\mathrm{ whole \ numbers, \ and \ must \ not \ share \ a \ 
                            common \ factor}');
        $this->setQuestion('\mathrm{Find \ the \ quadratic}');
        if ($coefficients[1] < 0){
            $this->setAnswer($coefficients[0].'x^2'.$coefficients[1].'x+'.$coefficients[2]);
        } else {
            $this->setAnswer($coefficients[0].'x^2+'.$coefficients[1].'x+'.$coefficients[2]);
        }


    }

    function twoRoots(){
        $root1 = random_int(5,100)/10;
        $root1 = (random_int(0,1)?-$root1:$root1);

        $root2 = random_int(5,100)/10;
        $root2 = (random_int(0,1)?-$root2:$root2);

        $b = -($root1+$root2);
        $c = (-$root1)*(-$root2);

        $coefficients = $this->computeCoefficients($b,$c);

        if((10 * $root1) % 10 == 0 && (10 * $root2) % 10 == 0){
            $this->addToBlurb('\mathrm{A \ quadratic \ has \ two \ solutions \ } x_1= '.$root1.', \ x_2='.$root2);
        } else if((10 * $root1) % 10 == 0) {
            $this->addToBlurb('\mathrm{A \ quadratic \ has \ two \ solutions \ } x_1= '.$root1.', \ x_2='.$this->float2rat($root2));
        } else if ((10 * $root2) % 10 == 0){
            $this->addToBlurb('\mathrm{A \ quadratic \ has \ two \ solutions \ } x_1= '.$this->float2rat($root1).', \ x_2='.$root2);
        } else {
            $this->addToBlurb('\mathrm{A \ quadratic \ has \ two \ solutions \ } x_1= '.$this->float2rat($root1).', \ x_2='.$this->float2rat($root2));
        }
        $this->addToBlurb('\mathrm{Find \ the \ original \ quadratic \ by \ giving \ your \ answer \ 
                            in \ the \ form \ } ax^2+bx+c \mathrm{ \ where \ } a > 0, \\space b, \mathrm{ 
                            \ and \ } c \mathrm{ \ are \ }');
        $this->addToBlurb('\mathrm{ whole \ numbers, \ and \ must \ not \ share \ a \ 
                            common \ factor}');
        $this->setQuestion('\mathrm{Find \ the \ quadratic}');
        if ($coefficients[1] < 0){
            $this->setAnswer($coefficients[0].'x^2'.$coefficients[1].'x+'.$coefficients[2]);
        } else {
            $this->setAnswer($coefficients[0].'x^2+'.$coefficients[1].'x+'.$coefficients[2]);
        }

    }

    function computeCoefficients($n_1, $n_2, $tolerance = 1.e-6) {
        $negative1 = false;
        $negative2 = false;

        $multiplier = 100;
        $n_1 *= $multiplier;
        $n_2 *= $multiplier;

        $factor = 100;
        $commonFactors = [];
        while($factor > 1){
            if($n_1 % $factor == 0 && $n_2 % $factor == 0 && $multiplier % $factor == 0){
                array_push($commonFactors, $factor);
            }
            $factor--;
        }

        if(count($commonFactors)==0){
            return [$multiplier,$n_1,$n_2];
        } else {
            $highestCommonFactor = max($commonFactors);
            return [$multiplier/$highestCommonFactor,$n_1/$highestCommonFactor, 
                    $n_2/$highestCommonFactor];
        }
        
    }

}

?>
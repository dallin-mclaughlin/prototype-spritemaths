<?php

//This question starts with a quadratic of the form x^2 + bx + c = 0  where n must be found
//The student is given the information that two roots exist and one of them is a multiplier
//times the other root i.e. root_2 = multiplier * root_1
//Since quadratic equations can be rewritten as (x + root_1)(x + multiplier * root_1) = 0
//expanded gives x^2 + (multiplier + 1) * root_1 * x + multiplier * root_1^2


class QuadraticAlgebraicSolutions extends Question{
    

    function __construct(){
        
        $root1coefficient = (random_int(0,1)?random_int(2,7):-random_int(2,7));
        $root2coefficient = (random_int(0,1)?random_int(2,7):-random_int(2,7));

        $b = $root1coefficient+$root2coefficient;
        $c = $root1coefficient*$root2coefficient;

        $rootVariables = array("k","v","t","p","d");
        $rootVariable = $rootVariables[array_rand($rootVariables)];

        echo $rootVariable;

        $ratio = $this->float2rat($root1coefficient / $root2coefficient);

        if($b < 0 && $c < 0){
            echo 'first';
            $this->addToBlurb('\mathrm{Given \ } x^2'.$b.$rootVariable.'x'.
            $c.$rootVariable.'^2=0 \mathrm{ \ where \ } '.$rootVariable.' \mathrm{
            \ is \ non-zero}');
        } else if($b < 0 && $c > 0){
            echo 'second';
            $this->addToBlurb('\mathrm{Given \ } x^2'.$b.$rootVariable.'x+'.
            $c.$rootVariable.'^2=0 \mathrm{ \ where \ } '.$rootVariable.' \mathrm{
            \ is \ non-zero}');
        } else if($b == 0 && $c < 0){
            echo 'third';
            $this->addToBlurb('\mathrm{Given \ } x^2'.
            $c.$rootVariable.'^2=0 \mathrm{ \ where \ } '.$rootVariable.' \mathrm{
            \ is \ non-zero}');
        } else if($b == 0 && $c > 0){
            echo 'fourth';
            $this->addToBlurb('\mathrm{Given \ } x^2+'.
            $c.$rootVariable.'^2=0 \mathrm{ \ where \ } '.$rootVariable.' \mathrm{
            \ is \ non-zero}');
        } else if($b > 0 && $c < 0){
            echo 'fifth';
            $this->addToBlurb('\mathrm{Given \ } x^2+'.$b.$rootVariable.'x'.
            $c.$rootVariable.'^2=0 \mathrm{ \ where \ } '.$rootVariable.' \mathrm{
            \ is \ non-zero}');
        } else if($b > 0 && $c > 0){
            echo 'sixth';
            $this->addToBlurb('\mathrm{Given \ } x^2+'.$b.$rootVariable.'x+'.
            $c.$rootVariable.'^2=0 \mathrm{ \ where \ } '.$rootVariable.' \mathrm{
            \ is \ non-zero}');
        }
        $this->addToBlurb('\mathrm{Extra: \ Show \ also \ that \ one \ solution \ is  \ } '.$ratio.
                            ' \mathrm{ \ times \ the \ other}');
        $this->setQuestion('\mathrm{Determine \ the \ two \ roots}');
        $this->setAnswer($root1coefficient.$rootVariable.','.$root2coefficient.$rootVariable);
    }

}

?>
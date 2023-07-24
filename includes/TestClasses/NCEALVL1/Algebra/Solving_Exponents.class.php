<?php

class SolvingExponents extends Question{

    function __construct(){
        $choose = random_int(0,2);

        if($choose == 0){
            $this->exponent0();
        } else if($choose == 1){
            $this->exponent1();
        } else if($choose == 2){
            $this->exponent2();
        }
    }

    function exponent0(){
        $exponent = random_int(1,4);
        $number = random_int(3,6);
        $RHSide = pow($number, $exponent);

        $this->setQuestion("\mathrm{ Solve \ } ".$number."^{x}=".$RHSide);
        $this->setAnswer($exponent);
    }

    function exponent1(){
        $exponent = random_int(1,3);
        $number = random_int(3,6);
        $RHSide = pow($number, $exponent*2);

        $this->setQuestion("\mathrm{ Solve \ } ".$number."^{2x}=".$RHSide);
        $this->setAnswer($exponent);
    }

    function exponent2(){
        $exponent1 = random_int(1,2);
        $exponent2 = random_int(1,2);
        $number = random_int(3,6);
        $RHSide = pow($number, $exponent1 + $exponent2);

        if(random_int(0,1)){
            $this->setQuestion("\mathrm{ Solve \ } ".$number."^{x} \\times ".$number."^{".$exponent2."}=".$RHSide);
            $this->setAnswer($exponent1);
        } else {
            $this->setQuestion("\mathrm{ Solve \ } ".$number."^".$exponent1." \\times ".$number."^{x}=".$RHSide);
            $this->setAnswer($exponent2);
        }
        
    }

    

}


?>
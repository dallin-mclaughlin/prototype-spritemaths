<?php

//This question starts with a quadratic of the form x^2 + bx + c = 0  where n must be found
//The student is given the information that two roots exist and one of them is a multiplier
//times the other root i.e. root_2 = multiplier * root_1
//Since quadratic equations can be rewritten as (x + root_1)(x + multiplier * root_1) = 0
//expanded gives x^2 + (multiplier + 1) * root_1 * x + multiplier * root_1^2


class IdentifyNaturalNumbers extends Question{
    

    function __construct(){

        $length = random_int(1,5);
        $numbers = [];
        for($i = 0; $i < $length; $i++){
            array_push($numbers, $this->getRandomRealNumber());
        }
        array_push($numbers, $this->getRandomNaturalNumber());
        shuffle($numbers);

     
        $this->addToBlurb('A = \left\{'.$this->getNumberElements($numbers).' \right\}');
        $this->setQuestion('\mathrm{List \ the \ natural \ numbers \ contained \ in \ the \ set \ } A');
        $this->setAnswer($this->getNaturalNumbers($numbers));
        echo $this->getNaturalNumbers($numbers);
    }

    function getNumberElements($numbers){
        $elementsString = '';
        for($i = 0; $i < count($numbers)-1;$i++){
            $elementsString .= $numbers[$i].', \ ';
        }
        $elementsString .= $numbers[count($numbers)-1];
        return $elementsString;
    }

    function getNaturalNumbers($numbers){
        $naturalsString = '';
        foreach($numbers as $number){
            if($this->isNatural($number)){
                $naturalsString .= $number.',';
            }
        }

        $naturalsString = substr($naturalsString, 0, -1);

        return $naturalsString;
    }

    function isNatural($number){
        //I need this condition '===0' because usually the -ve sign is at the zeroth position
        if(stripos($number, "e")===0){
            return False;
        } else if(stripos($number, ".")){
            return False;
        } else if(stripos($number, "pi")){
            return False;
        } else if(stripos($number, "sqrt")){
            return False;
        } else if(stripos($number, "frac")){
            return False;
        //I need this condition '===0' because usually the -ve sign is at the zeroth position
        } else if(stripos($number, "-")===0){
            return False;
        } else {
            return True;
        }
    }

}

?>
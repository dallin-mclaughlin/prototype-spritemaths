<?php


//This question starts with a quadratic of the form x^2 + bx + c = 0  where n must be found
//The student is given the information that two roots exist and one of them is a multiplier
//times the other root i.e. root_2 = multiplier * root_1
//Since quadratic equations can be rewritten as (x + root_1)(x + multiplier * root_1) = 0
//expanded gives x^2 + (multiplier + 1) * root_1 * x + multiplier * root_1^2


class QuadraticLinearUnknown extends Question{

    private $multiplier;
    private $b;
    private $c;
    

    function __construct(){
        //Multiplier 
        $this->multiplier = random_int(2,6);
        
        //the number multiplied by the multiplier to get c. to make it easy for the student
        //it should be a square number 
        $n = random_int(3,25);

        $this->c = $n * $this->multiplier;

        $this->b = sqrt($n) * ($this->multiplier + 1);


        $this->addToBlurb('\mathrm{Give \ your \ answer \ in \ exact \ form}');
        $this->addToBlurb('\mathrm{Given \ the \ equation \ } x^2+px+'.$this->c.'=0 \ 
                            \mathrm{ \ and \ one \ root \ is \ '.
                            $this->getMultiplierWord($this->multiplier).' \ times \ the \ other
                            \ root}');
        $this->setQuestion('\mathrm{What \ is \ } p \mathrm{ \ ?}');
        $this->setAnswer($this->b);
    }

    function getMultiplierWord($multiplier){
        switch($multiplier){
            case 2:
                return 'two';
                break;
            case 3:
                return 'three';
                break;
            case 4:
                return 'four';
                break;
            case 5:
                return 'five';
                break;
            case 6:
                return 'six';
                break;
        }
    }

}

?>
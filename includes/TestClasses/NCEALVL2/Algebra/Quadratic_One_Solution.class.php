<?php


//This question starts with a quadratic of the form ax^2 + bx + c = 0 


class QuadraticOneSolution extends Question{

    private $a;
    private $b;
    private $c;
    

    function __construct(){
        //Multiplier 
        $this->choose = random_int(0,2);
        if ($this->choose == 0){
            $this->optionOne();
        } else if ($this->choose == 1){
            $this->optionTwo();
        } else if ($this->choose == 2){
            $this->optionThree();
        }
        $this->setQuestion('\mathrm{Determine \ the \ value } \ m');
    }

    function optionOne(){
        $this->b = random_int(2,12);
        $this->c = random_int(1,50);

        $this->setAnswer(pow($this->b,2)/(4 * $this->c));

        $this->addToBlurb('\mathrm{Given \ } mx^2+'.$this->b.'x+'.$this->c.'=0 \ \mathrm{ has \ only \ one \ real \ solution}');
    }

    function optionTwo(){
        $this->a = random_int(2,12);
        $this->c = random_int(4,32);

        $this->setAnswer(2*sqrt($this->a*$this->c));

        $this->addToBlurb('\mathrm{Given \ } '.$this->a.'x^2+mx+'.$this->c.'=0 \ \mathrm{ has \ only \ one \ real \ solution}');
    }

    function optionThree(){
        $this->a = random_int(1,50);
        $this->b = random_int(2,12);

        $this->setAnswer(pow($this->b,2)/(4 * $this->a));

        $this->addToBlurb('\mathrm{Given \ } '.$this->a.'x^2+'.$this->b.'x+m=0 \ \mathrm{ has \ only \ one \ real \ solution}');
    }

}

?>
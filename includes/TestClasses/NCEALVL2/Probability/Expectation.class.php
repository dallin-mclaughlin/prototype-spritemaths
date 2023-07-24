<?php

    class Expectation extends Question{   
        
        function __construct(){
            $options = ["dice","coin"];
            $option = $options[random_int(0,count($options)-1)];
            if($option == "dice"){
                $this->dice();
            } else if($option == "coin"){
                $this->coin();
            }

        }

        function dice(){
            $numRolls = random_int(5,20);
            $chance = 1/6;
            $expectation = $chance * $numRolls;

            $this->setQuestion('\mathrm{ How \ many \ 6s \ do \ you \ expect \ for \ '.$numRolls.' \ rolls \ on \ a \ six \ sided \ dice?}');
            $this->setAnswer($expectation);
        }

        function coin(){
            $numRolls = random_int(5,20);
            $chance = 1/2;
            $expectation = $chance * $numRolls;

            $this->setQuestion('\mathrm{ How \ many \ tails \ do \ you \ expect \ for \ '.$numRolls.' \ coin \ tosses?}');
            $this->setAnswer($expectation);
        }

    }

?>



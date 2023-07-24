<?php

//This question starts with a quadratic of the form x^2 + bx + c = 0  where n must be found
//The student is given the information that two roots exist and one of them is a multiplier
//times the other root i.e. root_2 = multiplier * root_1
//Since quadratic equations can be rewritten as (x + root_1)(x + multiplier * root_1) = 0
//expanded gives x^2 + (multiplier + 1) * root_1 * x + multiplier * root_1^2


class Permutations extends Question{
    
    function __construct(){

        $questions = ['poolballs','numbers','fruit',
                        'team','lotto'];
        $question = $questions[array_rand($questions)];

        if($question == 'icecreams'){
            $this->icecreamQuestion();
        } else if($question == 'shirts'){
            $this->shirtsQuestion();
        } else if($question == 'chocolate'){
            $this->chocolateQuestion();
        } else if($question == 'numbers'){
            $this->numbersQuestion();
        } else if($question == 'fruit'){
            $this->fruitQuestion();
        }
    
    }

    function icecreamQuestion(){
        $flavours = ['Chocolate','Berry','Vanilla','Hokey \ Pokey','Caramel','Boysenberry',
                    'Orange','Banana','Goody \ Goody \ Gum \ Drops','Eggnog','Strawberry',
                    'Butter \ Pecan','Eskimo','Lemon \ Custard','Neapolitan'];
        
        $n = random_int(5,9);
        $r = random_int(2,4);

        $possibleFlavours = [];
        $count = 0;
        while($count < $n){
            $possibleFlavour = $flavours[array_rand($flavours)];
            if(!in_array($possibleFlavour, $possibleFlavours)){
                array_push($possibleFlavours, $possibleFlavour);
                $count++;
            }
        }

        $this->addToBlurb('\mathrm{ There \ are \ } '.$n.' \mathrm{ \ flavours \ to \ choose \ 
                            from \ to \ make \ a \ } '.$r.' \mathrm{-scoop \ icecream. }');
        $this->addToBlurb('\mathrm{ The \ list \ of \ possible \ flavours \ are \ '.
                            $this->makeSelectionString($possibleFlavours));
        $this->addToBlurb('\mathrm{ Assume \ that \ the \ flavours \ can \ be \ selected \ 
                            more \ than \ once \ and \ order \ is \ not \ important } ');
        $this->setQuestion('\mathrm{ Determine \ the \ number \ of \ possible \ icecream \ 
                            flavour \ combinations } ');
        $this->setAnswer($this->calculateFactorial($r + $n - 1)/($this->calculateFactorial($r)*
                            $this->calculateFactorial($n - 1)));


    }

    function shirtsQuestion(){
        $colors = ['White', 'Red','Orange','Blue','Green','Brown','Purple','Pink',
                    'Grey','Black','Violet','Cyan'];
        
        $n = random_int(3,6);
        $r = random_int(1,2);

        $possibleColors = [];
        $count = 0;
        while($count < $n){
            $possibleColor = $colors[array_rand($colors)];
            if(!in_array($possibleColor, $possibleColors)){
                array_push($possibleColors, $possibleColor);
                $count++;
            }
        }

        $this->addToBlurb('\mathrm{ There \ are \ } '.$n.' \mathrm{ \ colors \ to \ choose \ 
                            from \ to \ make \ a \ shirt \ with \ } '.$r.' \mathrm{ \ areas \ to \ color. }');
        $this->addToBlurb('\mathrm{ The \ list \ of \ possible \ colors \ are \ '.
                            $this->makeSelectionString($possibleColors));
        $this->addToBlurb('\mathrm{ Assume \ that \ the \ colors \ can \ be \ selected \ 
                            more \ than \ once \ and \ order \ is \ not \ important } ');
        $this->setQuestion('\mathrm{ Determine \ the \ number \ of \ possible \ color \ 
                             combinations } ');
        $this->setAnswer($this->calculateFactorial($r + $n - 1)/($this->calculateFactorial($r)*
                            $this->calculateFactorial($n - 1)));
    }

    function chocolateQuestion(){
        $flavours = ['Milk','White','Dark','Semisweet','Bittersweet','Couverture',
                    'Ruby','Wasabi','Chili','Hazelnut','Almond'];
        
        $n = random_int(5,9);
        $r = random_int(2,4);

        $possibleFlavours = [];
        $count = 0;
        while($count < $n){
            $possibleFlavour = $flavours[array_rand($flavours)];
            if(!in_array($possibleFlavour, $possibleFlavours)){
                array_push($possibleFlavours, $possibleFlavour);
                $count++;
            }
        }

        $this->addToBlurb('\mathrm{ There \ are \ } '.$n.' \mathrm{ \ flavours \ to \ choose \ 
                            from \ to \ make \ a \ gift \ that \ contains \ } '.$r.' \mathrm{ \ bars \ of \ chocolate. }');
        $this->addToBlurb('\mathrm{ The \ list \ of \ possible \ flavours \ are \ '.
                            $this->makeSelectionString($possibleFlavours));
        $this->addToBlurb('\mathrm{ Assume \ that \ the \ flavours \ can \ be \ selected \ 
                            more \ than \ once \ and \ order \ is \ not \ important } ');
        $this->setQuestion('\mathrm{ Determine \ the \ number \ of \ possible \ chocolate \ 
                            bar \ selection \ combinations } ');
        $this->setAnswer($this->calculateFactorial($r + $n - 1)/($this->calculateFactorial($r)*
                            $this->calculateFactorial($n - 1)));

    }

    function numbersQuestion(){
        $tricks = ['Kickflip','Ollie','Nollie','Heelflip','Wallride','Grinds',
                    'Fakie \ Bigspin','Ollie \ North','Inward \ Heel','Blunt \ Fakie',
                    'No \ Comply','Board \ Slide','Fakie \ Heel \ Flip','Axle \ Stall'];
        $n = random_int(4,7);
        $r = random_int(2,4);

        $possibleTricks = [];
        $count = 0;
        while($count < $n){
            $possibleTrick = $tricks[array_rand($tricks)];
            if(!in_array($possibleTrick, $possibleTrick)){
                array_push($possibleTrick, $possibleTrick);
                $count++;
            }
        }

        $this->addToBlurb('\mathrm{ There \ are \ } '.$n.' \mathrm{ \ tricks \ to \ choose \ 
                             from \ to \ create \ a \ set \ that \ contains \ } '.$r.' \mathrm{ \ skateboard \ tricks. }');
        $this->addToBlurb('\mathrm{ The \ list \ of \ possible \ tricks \ are \ '.
                            $this->makeSelectionString($possibleTricks));
        $this->addToBlurb('\mathrm{ Assume \ that \ the \ tricks \ can \ be \ selected \ 
                            more \ than \ once \ and \ order \ is \ not \ important } ');
        $this->setQuestion('\mathrm{ Determine \ the \ number \ of \ possible \ trick \ 
                             combinations } ');
        $this->setAnswer($this->calculateFactorial($r + $n - 1)/($this->calculateFactorial($r)*
                            $this->calculateFactorial($n - 1)));
    }

    function fruitQuestion(){
        $fruit = ['Apple','Mango','Banana','Strawberry','Watermelon','Orange','Apricot',
                    'Peach','Plum','Kiwifruit','Passionfruit','Mandarin','Pear'];
        
        $n = random_int(7,12);
        $r = random_int(2,6);

        $possibleFruit = [];
        $count = 0;
        while($count < $n){
            $possibleFruit = $fruit[array_rand($fruit)];
            if(!in_array($possibleFruit, $possibleFruit)){
                array_push($possibleFruit, $possibleFruit);
                $count++;
            }
        }

        $this->addToBlurb('\mathrm{ There \ are \ } '.$n.' \mathrm{ \ types \ of \ fruit \ to \ choose \ 
                            from \ to \ fill \ a \ basket \ that \ contains \ } '.$r.' \mathrm{ \ pieces \ of \ fruit. }');
        $this->addToBlurb('\mathrm{ The \ list \ of \ possible \ flavours \ are \ '.
                            $this->makeSelectionString($possibleFruit));
        $this->addToBlurb('\mathrm{ Assume \ that \ the \ fruit \ can \ be \ chosen \ 
            more \ than \ once \ and \ order \ is \ not \ important } ');
        $this->setQuestion('\mathrm{ Determine \ the \ number \ of \ possible \ fruit \ 
                             combinations } ');
        $this->setAnswer($this->calculateFactorial($r + $n - 1)/($this->calculateFactorial($r)*
                            $this->calculateFactorial($n - 1)));

    }

    function makeSelectionString($selection){
        $selectionString = '';
        for($i = 0; $i < count($selection)-1; $i++){
            $selectionString .= $selection[$i].', \ ';
        }
        $selectionString .= $selection[$i].'. }';
        return $selectionString;
    }

}

?>
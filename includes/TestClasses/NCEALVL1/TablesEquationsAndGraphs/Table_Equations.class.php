<?php

    class TableEquations extends Question{   
        private $indices = [];
        private $values = [];
        
        function __construct(){
            $graphs = ['linear','quadratic','exponential'];

            $graph = $graphs[array_rand($graphs)];

            if($graph == 'linear'){
                $this->linearGraph();
            } else if($graph == 'quadratic'){
                $this->quadraticGraph();
            } else if($graph == 'exponential'){
                $this->exponentialGraph();
            }
        }

        function linearGraph(){
            $numValues = random_int(3,5);
            $gradient = (random_int(0,1))?random_int(1,6):-random_int(1,6);
            $intercept = (random_int(0,1))?random_int(1,9):-random_int(1,9);
            for($i = 0; $i < $numValues; $i++){
                array_push($this->indices, $i);
                array_push($this->values, $i*$gradient + $intercept);
            }

            $this->setQuestion('\mathrm{ Determine \ the \ equation \ of \ the \ graph }');

            $equation = 'y='.$gradient.'x+'.$intercept;
            $equation = str_replace("+-","-", $equation);
            $this->setAnswer($equation);
        }

        function quadraticGraph(){
            $numValues = random_int(3,5);
            $gradient = (random_int(0,1))?random_int(1,6):-random_int(1,6);
            $a = 1;
            $b = (random_int(0,1))?random_int(2,9):-random_int(2,9);
            $c = (random_int(0,1))?random_int(1,9):-random_int(1,9);
            $intercept = (random_int(0,1))?random_int(1,9):-random_int(1,9);
            for($i = 0; $i < $numValues; $i++){
                array_push($this->indices, $i);
                array_push($this->values, pow($i,2)+$b*$i+$c);
            }

            $this->setQuestion('\mathrm{ Determine \ the \ equation \ of \ the \ graph }');

            $equation = 'y=x^2+'.$b.'x+'.$c;
            $equation = str_replace("+-","-", $equation);
            $this->setAnswer($equation);
        }

        function exponentialGraph(){
            $numValues = random_int(3,5);
            $base = random_int(2,4);
            $c = (random_int(0,1))?random_int(1,2):-random_int(1,2);
            for($i = 0; $i < $numValues; $i++){
                array_push($this->indices, $i);
                array_push($this->values, pow($base, $i + $c));
            }

            $this->setQuestion('\mathrm{ Determine \ the \ equation \ of \ the \ graph }');

            $equation = 'y='.$base.'^{x+'.$c.'}';
            $equation = str_replace("+-","-", $equation);
            $this->setAnswer($equation);
        }

        function generateImage($id, $num){
            global $createdByTutor;
            $imageFile = '';
            $imageDimensions = $this->getSVGCanvasDimensions();
            $imageSVG = $this->drawTable($imageDimensions, $xTranslation=-150, $yTranslation=180,   $titles=0, $indices=$this->indices, $data=$this->values, $height=350, $width=300, $xCentre=0.5);
            if($createdByTutor){
                $imageFile = fopen("../../images/questionImages/".$id."_".$num.".txt", "w");
            } else {
                $imageFile = fopen("../images/questionImages/".$id."_".$num.".txt", "w");
            }

            $neededRef = "../images/questionImages/".$id."_".$num.".txt";

            fwrite($imageFile, $imageSVG);
            fclose($imageFile);


            return $neededRef;
        }


        
    }

?>



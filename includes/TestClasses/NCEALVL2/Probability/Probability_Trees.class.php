<?php

    class ProbabilityTrees extends Question{   
        private $titles = ["A","B","C","D","E","F"];
        private $data;
        
        function __construct(){
            $A = random_int(0,100)/100;
            $B = 1 - $A;
            $C = random_int(0,100)/100;
            $D = 1 - $C;
            $E = random_int(0,100)/100;
            $F = 1 - $E;
            $this->data = [$A, $B, $C, $D, $E, $F];

            $this->setQuestion('\mathrm{ What \ is \ the \ probability \ that \ C \ occurs?}');
            $this->setAnswer($A*$C);
        }

        function generateImage($id, $num){
            global $createdByTutor;
            $imageFile = '';
            $imageDimensions = $this->getSVGCanvasDimensions();
            $imageSVG = $this->drawProbabilityTree($imageDimensions = $imageDimensions,-$imageDimensions["width"]/2,150,$imageDimensions["width"]*1, $imageDimensions["height"]/1.5, $this->titles, $this->data);
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



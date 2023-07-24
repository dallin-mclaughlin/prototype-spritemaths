<?php

    class ProbabilityTables extends Question{   
        private $titles;
        private $data;
        
        function __construct(){
            $this->titles = ["Smoker","Not","Coffee","Not"];
            $this->data = [random_int(30,120),random_int(20,120),random_int(20,120),random_int(20,120)];

            $this->setQuestion('\mathrm{ What \ proportion \ of \ subjects \ drink \ coffee?}');
            $this->setAnswer($this->data[0]/($this->data[0]+$this->data[2]));

        }

        function generateImage($id, $num){
            global $createdByTutor;
            $imageFile = '';
            $imageDimensions = $this->getSVGCanvasDimensions();
            $imageSVG = $this->drawProbabilityTable($imageDimensions = $imageDimensions,-$imageDimensions["width"]/2,150,$imageDimensions["width"]*1, $imageDimensions["height"]/1.5, $this->titles,$this->data);
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



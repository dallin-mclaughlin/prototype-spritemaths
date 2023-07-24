<?php

//Random polygon shape where n is between 3 and 5
//Generate points on circumference of unit circle, scale if needed
//Find Centre of mass of polygon and then reposition vertices
//Add length sizes which will include algebra
//Find -ve reciprocal of each side's gradient so that the length sizes can be repositioned easily
    class NormalDistribution extends Question{
        private $standardDeviation;
        private $average;

        function __construct(){
            $this->standardDeviation = random_int(50,200)/100;
            $this->average = (random_int(0,1))?random_int(0,30)/10:-random_int(0,30)/10;
            $this->addToBlurb('\mathrm{ The \ standard \ deviation \ is \ }'.$this->standardDeviation.'.');
            $this->addToBlurb('\mathrm{ The \ mean \ is \ }'.$this->average);

            $zValue = random_int(0,500)/1000;
            $value = $zValue * $this->standardDeviation + $this->average;

            $this->setQuestion('\mathrm{ What \ is \ the \ standardised \ normal \ value \ when \ } x='.$value);
            $this->setAnswer($zValue);

        }

        function generateImage($id, $num){
            global $createdByTutor;
            $imageFile = '';
            $imageDimensions = $this->getSVGCanvasDimensions();
            $imageSVG = $this->drawGraphFunction($imageDimensions = $imageDimensions, 
                            $functions = [["type"=>"normaldis", "ranges"=>[[-10,10]],"a"=>$this->average, "b"=>$this->standardDeviation]], 
                            $xSpacing = 3, $includeGrid = True, $includeSubGrid=False, $translateGridX = -$this->average, 
                            $translateGridY = -2, $spacingUnits = 50);
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
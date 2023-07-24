<?php

//Random polygon shape where n is between 3 and 5
//Generate points on circumference of unit circle, scale if needed
//Find Centre of mass of polygon and then reposition vertices
//Add length sizes which will include algebra
//Find -ve reciprocal of each side's gradient so that the length sizes can be repositioned easily
    class FindQuadraticRoots extends Question{
        private $answer;
        private $question;

        private $root1;
        private $root2;

        private $a;
        private $b;
        private $c;

        private $blurb = [];

        function __construct(){
            $this->Question();
            $this->Answer();
        }

        function getBlurb(){
            return $this->blurb;
        }

        function generateImage($id, $num){
            global $createdByTutor;
            $imageFile = '';
            $imageDimensions = $this->getSVGCanvasDimensions();
            $xCentre = ($this->root1+$this->root2)/2;
            $randomXOffset = (random_int(0,1))?-random_int(1,2):random_int(1,2);
            $randomYOffset = (random_int(0,1))?-random_int(1,2):random_int(1,2);
            $imageSVG = $this->drawGraphFunction($imageDimensions = $imageDimensions, 
                            $functions = [["type"=>"quadratic", "ranges"=>[[-$xCentre-6,-$xCentre+6]],"a"=>$this->a, "b"=>$this->b, "c"=>$this->c]], 
                            $xSpacing = 3, $includeGrid = True, $includeSubGrid=False, $translateGridX = $xCentre + $randomXOffset, 
                            $translateGridY = $randomYOffset, $spacingUnits = 20);
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

        function generateQuadraticEquation(){
            $this->root1 = (random_int(0,1))?random_int(1,5):-random_int(1,5);
            $this->root2 = (random_int(0,1))?random_int(1,5):-random_int(1,5);

            $this->a = 1;
            $this->b = $this->root1 + $this->root2;
            $this->c = $this->root1 * $this->root2;
        }

        function Question(){
            $this->generateQuadraticEquation();
            array_push($this->blurb, "\mathrm{ Given \ the \ quadratic \ equation \ } y=".
            $this->getCoefficientString($this->a, 'x^2', False).
            $this->getCoefficientString($this->b,'x').
            $this->getCoefficientString($this->c,''));
            $this->question = "\mathrm{ Determine \ the \ } x \mathrm{-intercepts \ of \ the \ graph}";
        }

        function Answer(){
            if($this->root1==$this->root2){
                return -$this->root1;
            } else {
                $this->answer = -$this->root1.",".-$this->root2;
            }
        }

        function getQuestion(){
            return $this->question;
        }

        function getAnswer(){
            return $this->answer;
        }
    }

?>
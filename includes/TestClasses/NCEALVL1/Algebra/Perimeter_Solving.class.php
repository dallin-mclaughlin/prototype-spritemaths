<?php

//Random polygon shape where n is between 3 and 5
//Generate points on circumference of unit circle, scale if needed
//Find Centre of mass of polygon and then reposition vertices
//Add length sizes which will include algebra
//Find -ve reciprocal of each side's gradient so that the length sizes can be repositioned easily
    class PerimeterSolving extends Question{
        private $answer;
        private $question;

        private $numOfSides;

        private $blurb = ["\mathrm{Give \ your \ answer \ as \ an \ expression}"];

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

            //$shortSide = min($this->sideA, $this->sideB);
            //$longSide = max($this->sideA, $this->sideB);
            //$imageSVG = '<polygon points="110,50 320,50 290,150 80,150" fill = "white" style="stroke: black; stroke-width: 3;"></polygon>';
            //$imageSVG .= '<foreignObject x="185" y="175" width="50" height="100"><div xmlns="http://www.w3.org/1999/xhtml" style="font-family:Times; font-size:15px">\('.$num.'b-c\)</div></foreignObject>';
            //$imageSVG .= $this->drawDoubleArrow(80,160,290,160,0);
            //$imageSVG .= '<foreignObject x="325" y="110" width="50" height="100"><div xmlns="http://www.w3.org/1999/xhtml" style="font-family:Times; font-size:15px">\(b\)</div></foreignObject>';
            //$imageSVG .= $this->drawDoubleArrow(330,50,300,150,1);
            //$imageSVG .= '<foreignObject x="100" y="100" width="50" height="100"><div xmlns="http://www.w3.org/1999/xhtml" style="font-family:Times; font-size:15px">\(x+2\)</div></foreignObject>';
            //$imageSVG .= '<path d="m 100 150 a 15 15, 0, 0, 0, -15 -20" fill="white" style="stroke: black; stroke-width: 3";/>';

            //$imageSVG = $this->generateSVGPolygon(11, $this->getSVGCanvasDimensions(), 80, 0, 0, 0 * pi());
            //$imageSVG = $this->generateCartesianGrid($this->getSVGCanvasDimensions());
            //drawGraphFunction($imageDimensions, $function, $xSpacingProportion, $translateX=0, $translateY=0, $includeGrid=True, $translateGridX=0, $translateGridY=0, $spacingUnits = 40)
            $imageSVG = $this->drawGraphFunction($imageDimensions = $imageDimensions, 
                            $functions = [["type"=>"line", 
                            "ranges"=>[[-11,10]], "a"=>-1, "b"=>-1, "c"=>3, "d"=>0],
                            ["type"=>"circle", "a"=>2, "b"=>1, "c"=>3]], 
                            $xSpacing = 3, $includeGrid = True, $includeSubGrid = True,
                            $translateGridX = 0, $translateGridY = 0, $spacingUnits = 20);
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

        function GenerateSides(){
            $this->numOfSides = random_int(3,5);
        }

        function Question(){
            $this->question = "\mathrm{\ Determine \ the \ value \ of \ the \ quadratic \ } x^2";

            
        }

        function Answer(){
            //if($this->root1==$this->root2){
                //$this->answer = -$this->root1."";
            //} else {
                //$this->answer = -$this->root1.",".-$this->root2;
            //}
        }

        function getQuestion(){
            return $this->question;
        }

        function getAnswer(){
            return $this->answer;
        }
    }

?>
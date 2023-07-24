<?php

    class NumberPatterns extends Question{   
        private $range = [];
        private $type = '';
        
        function __construct(){
            $graphs = ['squares','triangles'];

            $graph = $graphs[array_rand($graphs)];
            $graph = 'squares';

            if($graph == 'squares'){
                $this->squares();
            } else if($graph == 'triangles'){
                $this->triangles();
            }
        }

        function squares(){
            $this->type = 'squares';
            $startNum = random_int(1,3);
            if($startNum ==1){
                $this->range = [1,3,4,2];
            } else if($startNum ==2){
                $this->range = [2,4,5,3];
            } else if($startNum ==3){
                $this->range = [3,5,6,4];
            }

            $this->setQuestion('\mathrm{ Determine \ the \ equation \ of \ the \ graphs }');

            $equation = 'y=5x+c';
            $equation = str_replace("+-","-", $equation);
            $this->setAnswer($equation);
        }

        function triangles(){
            $this->type = 'triangles';
            $startNum = random_int(1,3);
            if($startNum ==1){
                $this->range = [1,3,5,7];
            } else if($startNum ==2){
                $this->range = [3,5,7,9];
            } else if($startNum ==3){
                $this->range = [5,7,9,11];
            }

            $this->setQuestion('\mathrm{ Determine \ the \ equation \ of \ the \ graph }');

            $equation = 'y=5x+c';
            $equation = str_replace("+-","-", $equation);
            $this->setAnswer($equation);
        }

        function generateImage($id, $num){
            global $createdByTutor;
            $imageFile = '';
            $imageDimensions = $this->getSVGCanvasDimensions();
            if($this->type == 'squares'){
                $imageSVG = $this->drawSquarePatterns($imageDimensions = $imageDimensions,$this->range);
            } else if($this->type == 'triangles'){
                $imageSVG = $this->drawTrianglePatterns($imageDimensions = $imageDimensions,$this->range);
            }
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

        function drawSquarePatterns($imageDimensions, $range){
            $boxWidth = 40;
            $coords = [1,-1];
            $translation = [-110,75];
            $SVGstring = '';
            $SVGstring .= '<line x1="0" y1="'.($imageDimensions["height"]/2).'" x2="'.($imageDimensions["width"]).'" y2="'.($imageDimensions["height"]/2).'" fill = "white" style="stroke: black; stroke-width: 2;"></line>';
            $SVGstring .= '<line x1="'.($imageDimensions["width"]/2).'" y1="0" x2="'.($imageDimensions["width"]/2).'" y2="'.($imageDimensions["height"]).'" fill = "white" style="stroke: black; stroke-width: 2;"></line>';
            for($i=0; $i < count($range); $i++){
                $coords = $this->rotateMatrix(3*pi()/2, $coords);
                $SVGstring .= '<rect x="'.($imageDimensions["width"]/2 + $coords[0] * $imageDimensions["width"]/4).'" y="'.($imageDimensions["height"]/2 + $coords[1] * $imageDimensions["height"]/4).'" width="'.$boxWidth.'" height="'.$boxWidth.'" style="fill:white; stroke-width:2; stroke:black;"/>';
                $SVGstring .= '<foreignObject x="'.($imageDimensions["width"]/2 + $coords[0] * $imageDimensions["width"]/4 + $translation[0]).'" y="'.($imageDimensions["height"]/2 + $coords[1] * $imageDimensions["height"]/4 + $translation[1]).'" width="100" height="100"><div xmlns="http://www.w3.org/1999/xhtml" style="font-family:Times; font-size:20px">\(n='.($range[$i]).'\)</div></foreignObject>';
                $SVGstring .= $this->drawSquare($range[$i], $coords, $imageDimensions);
            }
            return $SVGstring;
        }

        function drawTrianglePatterns($imageDimensions, $range){
            $SVGstring = '';
            $SVGstring .= '<line x1="0" y1="'.($imageDimensions["height"]/2).'" x2="'.($imageDimensions["width"]).'" y2="'.($imageDimensions["height"]/2).'" fill = "white" style="stroke: black; stroke-width: 2;"></line>';
            $SVGstring .= '<line x1="'.($imageDimensions["width"]/2).'" y1="0" x2="'.($imageDimensions["width"]/2).'" y2="'.($imageDimensions["height"]).'" fill = "white" style="stroke: black; stroke-width: 2;"></line>';
            return $SVGstring;
        }

        function drawSquare($num, $coords, $imageDimensions){
            $SVGstring = '';
            for($i = $num; $i > 0; $i--){
                break;
            }
        }

        function drawTriangle(){

        }


        function rotateMatrix($angle, $vector){
            $rotationMatrix = [[cos($angle), -sin($angle)],
                                [sin($angle), cos($angle)]];

            $x = $rotationMatrix[0][0] * $vector[0] + $rotationMatrix[0][1] * $vector[1];
            $y = $rotationMatrix[1][0] * $vector[0] + $rotationMatrix[1][1] * $vector[1];
            
            return [$x, $y];
        }


        
    }

?>



<?php

    class BasicReasonsQuestion extends Question{
        
        private $answer;
        private $question;

        private $angle;
        private $otherAngle;
        private $sideC;
        private $area;

        private $polygonName;

        private $ran;
        private $blurb = [];

        function __construct(){
            $this->Question();
            $this->Answer();
        }

        function getBlurb(){
            return $this->blurb;
        }
        

        function pickQuestion(){
            array_push($this->blurb, '\mathrm{Please \ include \ a \ suitable \ geometric \ reason \ for \ your \ answer}');
            $this->ran = random_int(0,5);
            $this->ran = 0;

            switch($this->ran){
                case 0:
                    $this->generateStraightLine();
                    break;
                case 1:
                    $this->generateVerticallyOpposite();
                    break;
                case 2:
                    $this->generateCointerior();
                    break;
                case 3:
                    $this->generateTriangle();
                    break;
                case 4:
                    $this->generateCorresponding();
                    break;
                case 5:
                    $this->generateAlternate();
                    break;
                case 6:
                    $this->generateSameArc();
                    break;
                case 7:
                    $this->generateSemicircle();
                    break;
            }
        }

        function generateStraightLine(){
            //this uses only the sideA datafield
            $this->angle = random_int(200,1600)/10;
            $this->otherAngle = 180-$this->angle;
        }

        function generateRectangle(){
            //this uses the sideA and sideB datafields
            $this->polygonName = 'Rectangle';
            $this->sideA = random_int(1,8);
            $this->sideB = random_int(1,8);
            $this->area = $this->sideA*$this->sideB;

        }

        function generateTriangle(){
            //this uses the sideA (base) and sideB (vertical height) datafields
            $this->polygonName = 'Triangle';
            $this->sideA = random_int(1,8);
            $this->sideB = random_int(1,8);
            $this->area = 0.5*$this->sideA*$this->sideB;
        }

        function generateCircle(){
            //this uses the sideA (radius) datafields
            $this->polygonName = 'Circle';
            $this->sideA = random_int(1,8);
            $this->area = pi()*($this->sideA)**2;
        }

        function generateTrapezium(){
            //this uses the sideA (longer side) sideB (shorter side) and sideC (vertical height) datafields
            $this->polygonName = 'Trapezium';
            $this->sideA = random_int(1,8);
            $this->sideB = random_int(1,8);
            $this->sideC = random_int(1,8);
            $this->area = 0.5*$this->sideC*($this->sideA + $this->sideB);
        }

        function generateParallelogram(){
            //this uses the sideA (base) sideB (side, not vertical height) and sideC (angle) datafields
            $this->polygonName = 'Parallelogram';
            $this->sideA = random_int(1,8);
            $this->sideB = random_int(1,8);
            $this->sideC = random_int(200,750)/10; //in the range(20.0-75.0 degrees)
            $this->area = $this->sideA*$this->sideB*sin(deg2rad($this->sideC));
        }

        function generateStraightLineImage($id, $num){
            global $createdByTutor;
            $imageFile = '';
            $neededRef = '';

            $SVGwidth = 400;
            $SVGheight = 200;
            $lineTuple = [[80,80],[320,120]];

            $imageSVG = '<line x= "150" y = "50" width = "100" height = "100" fill = "white" style="stroke: black; stroke-width: 3;"></rect>';
            $imageSVG .= '<foreignObject x="260" y="90" width="50" height="50"><div xmlns="http://www.w3.org/1999/xhtml" style="font-family:Times; font-size:15px">\('.$this->sideA.'\)</div></foreignObject>';
            $imageSVG .= $this->drawDoubleArrow(265,50,265,150,1);
            
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

        function generateRectangleImage($id, $num){
            global $createdByTutor;
            $imageFile = '';
            $neededRef = '';

            $longSide = max($this->sideA, $this->sideB);
            $shortSide = min($this->sideA, $this->sideB);
            $imageSVG = '<rect x= "75" y = "50" width = "250" height = "100" fill = "white" style="stroke: black; stroke-width: 3;"></rect>';
            $imageSVG .= '<foreignObject x="330" y="90" width="50" height="50"><div xmlns="http://www.w3.org/1999/xhtml" style="font-family:Times; font-size:15px">\('.$shortSide.'\)</div></foreignObject>';
            
            $imageSVG .= $this->drawDoubleArrow(340,50,340,150,1);

            $imageSVG .= '<foreignObject x="180" y="15" width="50" height="50"><div xmlns="http://www.w3.org/1999/xhtml" style="font-family:Times; font-size:15px">\('.$longSide.'\)</div></foreignObject>';
            $imageSVG .= $this->drawDoubleArrow(75,40,325,40,0);
            
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

        function generateTriangleImage($id, $num){
            global $createdByTutor;
            $imageFile = '';
            $neededRef = '';

            $longSide = max($this->sideA, $this->sideB);
            $shortSide = min($this->sideA, $this->sideB);
            $imageSVG = '<polygon points="200,25 280,165 120,165" fill = "white" style="stroke: black; stroke-width: 3;"></polygon>';
            $imageSVG .= '<foreignObject x="175" y="180" width="50" height="50"><div xmlns="http://www.w3.org/1999/xhtml" style="font-family:Times; font-size:15px">\('.$longSide.'\)</div></foreignObject>';
                $imageSVG .= '<foreignObject x="280" y="90" width="50" height="50"><div xmlns="http://www.w3.org/1999/xhtml" style="font-family:Times; font-size:15px">\('.$shortSide.'\)</div></foreignObject>';
            $imageSVG .= $this->drawDoubleArrow(290,25,290,165,1);
            $imageSVG .= $this->drawDoubleArrow(120,175,280,175,0);
            
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

        function generateCircleImage($id, $num){
            global $createdByTutor;
            $imageFile = '';
            $neededRef = '';

            $imageSVG = ' <circle cx="200" cy="100" r="75" fill="white" style="stroke: black; stroke-width: 3;"/>';
            $imageSVG .= '<foreignObject x="205" y="60" width="50" height="50"><div xmlns="http://www.w3.org/1999/xhtml" style="font-family:Times; font-size:15px">\(r='.$this->sideA.'\)</div></foreignObject>';
            $imageSVG .= $this->drawDoubleArrow(200,25,200,100,1);
            
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

        function generateTrapeziumImage($id, $num){
            global $createdByTutor;
            $imageFile = '';
            $neededRef = '';

            $sides = array($this->sideA, $this->sideB);
            sort($sides);
            $imageSVG = '<polygon points="110,50 290,50 320,150 80,150" fill = "white" style="stroke: black; stroke-width: 3;"></polygon>';
            $imageSVG .= '<foreignObject x="180" y="15" width="50" height="50"><div xmlns="http://www.w3.org/1999/xhtml" style="font-family:Times; font-size:15px">\('.$sides[0].'\)</div></foreignObject>';
            $imageSVG .= $this->drawDoubleArrow(70,50,70,150,1);
            $imageSVG .= '<foreignObject x="180" y="170" width="50" height="50"><div xmlns="http://www.w3.org/1999/xhtml" style="font-family:Times; font-size:15px">\('.$sides[1].'\)</div></foreignObject>';
            $imageSVG .= $this->drawDoubleArrow(80,160,320,160,0);
            $imageSVG .= '<foreignObject x="30" y="90" width="50" height="50"><div xmlns="http://www.w3.org/1999/xhtml" style="font-family:Times; font-size:15px">\('.$this->sideC.'\)</div></foreignObject>';
            $imageSVG .= $this->drawDoubleArrow(110,40,290,40,0);
            
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

        function generateParallelogramImage($id, $num){
            global $createdByTutor;
            $imageFile = '';
            $neededRef = '';

            $shortSide = min($this->sideA, $this->sideB);
            $longSide = max($this->sideA, $this->sideB);
            $imageSVG = '<polygon points="110,50 320,50 290,150 80,150" fill = "white" style="stroke: black; stroke-width: 3;"></polygon>';
            $imageSVG .= '<foreignObject x="160" y="170" width="50" height="50"><div xmlns="http://www.w3.org/1999/xhtml" style="font-family:Times; font-size:15px">\('.$longSide.'\)</div></foreignObject>';
            $imageSVG .= $this->drawDoubleArrow(80,160,290,160,0);
            $imageSVG .= '<foreignObject x="310" y="90" width="50" height="50"><div xmlns="http://www.w3.org/1999/xhtml" style="font-family:Times; font-size:15px">\('.$shortSide.'\)</div></foreignObject>';
            $imageSVG .= $this->drawDoubleArrow(330,50,300,150,1);
            $imageSVG .= '<foreignObject x="95" y="120" width="50" height="50"><div xmlns="http://www.w3.org/1999/xhtml" style="font-family:Times; font-size:15px">\('.$this->sideC.'^{\circ}\)</div></foreignObject>';
            $imageSVG .= '<path d="m 100 150 a 15 15, 0, 0, 0, -15 -20" fill="white" style="stroke: black; stroke-width: 3";/>';
            
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

        function generateImage($id, $num){
            switch($this->ran){
                case 0:
                    return $this->generateStraightLineImage($id, $num);
                    break;
                case 1:
                    return $this->generateRectangleImage($id, $num);
                    break;
                case 2:
                    return $this->generateTriangleImage($id, $num);
                    break;
                case 3:
                    return $this->generateCircleImage($id, $num);
                    break;
                case 4:
                    return $this->generateTrapeziumImage($id, $num);
                    break;
                case 5:
                    return $this->generateParallelogramImage($id, $num);
                    break;
            }

        }
        //arrow that goes from top to bottom or left to right
        //orientation = 0 for horizontal arrow or 1 for vertical arrow
        function drawDoubleArrow($point1x, $point1y, $point2x, $point2y, $orientation){
            $arrowDistanceFrom = 5;
            $distanceFromLine = 3;
            //Potential division by zero here. Not good!
            //$gradient = ($point2y-$point1y)/($point2x-$point1x);
            //$negativeReciprocalGradient = (-1)/$gradient;
            $SVGarrow = '<line x1 ="'.$point1x.'" y1 = "'.$point1y.'" x2 = "'.$point2x.'" y2 = "'.$point2y.'" stroke="black" stroke-width="2" />';
            if($orientation==1){
                $topLeftArrowX = $point1x-$distanceFromLine;
                $topLeftArrowY = $point1y+$arrowDistanceFrom;
                $topRightArrowX = $point1x+$distanceFromLine;
                $topRightArrowY = $point1y+$arrowDistanceFrom;

                $bottomLeftArrowX = $point2x-$distanceFromLine;
                $bottomLeftArrowY = $point2y-$arrowDistanceFrom;
                $bottomRightArrowX = $point2x+$distanceFromLine;
                $bottomRightArrowY = $point2y-$arrowDistanceFrom;

                $topLeftLineX = $point1x - $arrowDistanceFrom;
                $topLeftLineY = $point1y;
                $topRightLineX = $point1x + $arrowDistanceFrom;
                $topRightLineY = $point1y;

                $bottomLeftLineX = $point2x - $arrowDistanceFrom;
                $bottomLeftLineY = $point2y;
                $bottomRightLineX = $point2x + $arrowDistanceFrom;
                $bottomRightLineY = $point2y;

                $SVGarrow .= '<line x1 ="'.$point1x.'" y1 = "'.$point1y.'" x2 = "'.$topLeftArrowX.'" y2 = "'.$topLeftArrowY.'" stroke="black" stroke-width="2" />';
                $SVGarrow .= '<line x1 ="'.$point1x.'" y1 = "'.$point1y.'" x2 = "'.$topRightArrowX.'" y2 = "'.$topRightArrowY.'" stroke="black" stroke-width="2" />';
                $SVGarrow .= '<line x1 ="'.$point2x.'" y1 = "'.$point2y.'" x2 = "'.$bottomLeftArrowX.'" y2 = "'.$bottomLeftArrowY.'" stroke="black" stroke-width="2" />';
                $SVGarrow .= '<line x1 ="'.$point2x.'" y1 = "'.$point2y.'" x2 = "'.$bottomRightArrowX.'" y2 = "'.$bottomRightArrowY.'" stroke="black" stroke-width="2" />';

                $SVGarrow .= '<line x1 ="'.$topLeftLineX.'" y1 = "'.$topLeftLineY.'" x2 = "'.$topRightLineX.'" y2 = "'.$topRightLineY.'" stroke="black" stroke-width="2" />';
                $SVGarrow .= '<line x1 ="'.$bottomLeftLineX.'" y1 = "'.$bottomLeftLineY.'" x2 = "'.$bottomRightLineX.'" y2 = "'.$bottomRightLineY.'" stroke="black" stroke-width="2" />';
            } else {
                $leftTopArrowX = $point1x+$arrowDistanceFrom;
                $leftTopArrowY = $point1y-$distanceFromLine;
                $leftBottomArrowX = $point1x+$arrowDistanceFrom;
                $leftBottomArrowY = $point1y+$distanceFromLine;

                $rightTopArrowX = $point2x-$arrowDistanceFrom;
                $rightTopArrowY = $point2y-$distanceFromLine;
                $rightBottomArrowX = $point2x-$arrowDistanceFrom;
                $rightBottomArrowY = $point2y+$distanceFromLine;

                $leftTopLineX = $point1x;
                $leftTopLineY = $point1y - $arrowDistanceFrom;
                $leftBottomLineX = $point1x;
                $leftBottomLineY = $point1y + $arrowDistanceFrom;

                $rightTopLineX = $point2x;
                $rightTopLineY = $point2y - $arrowDistanceFrom;
                $rightBottomLineX = $point2x;
                $rightBottomLineY = $point2y + $arrowDistanceFrom;

                $SVGarrow .= '<line x1 ="'.$point1x.'" y1 = "'.$point1y.'" x2 = "'.$leftTopArrowX.'" y2 = "'.$leftTopArrowY.'" stroke="black" stroke-width="2" />';
                $SVGarrow .= '<line x1 ="'.$point1x.'" y1 = "'.$point1y.'" x2 = "'.$leftBottomArrowX.'" y2 = "'.$leftBottomArrowY.'" stroke="black" stroke-width="2" />';
                $SVGarrow .= '<line x1 ="'.$point2x.'" y1 = "'.$point2y.'" x2 = "'.$rightTopArrowX.'" y2 = "'.$rightTopArrowY.'" stroke="black" stroke-width="2" />';
                $SVGarrow .= '<line x1 ="'.$point2x.'" y1 = "'.$point2y.'" x2 = "'.$rightBottomArrowX.'" y2 = "'.$rightBottomArrowY.'" stroke="black" stroke-width="2" />';

                $SVGarrow .= '<line x1 ="'.$leftTopLineX.'" y1 = "'.$leftTopLineY.'" x2 = "'.$leftBottomLineX.'" y2 = "'.$leftBottomLineY.'" stroke="black" stroke-width="2" />';
                $SVGarrow .= '<line x1 ="'.$rightTopLineX.'" y1 = "'.$rightTopLineY.'" x2 = "'.$rightBottomLineX.'" y2 = "'.$rightBottomLineY.'" stroke="black" stroke-width="2" />';
            }
            return $SVGarrow;
        }
        

        function Question(){
            $this->pickPolygon();
            $this->question = '\mathrm{\ Find \ the \ area \ of \ the \ '.$this->polygonName.' \ to \ 2 \ d.p.}';

        }

        function Answer(){
            $this->answer = round($this->area,2);
        }

        function getQuestion(){
            return $this->question;
        }

        function getAnswer(){
            return $this->answer;
        }
    }
?>
<?php

    class StraightLines extends Question{

        private $imageSVG = '';

        function __construct(){
            $circleRadius = 200;
            $angle = random_int(30,150);
            $findAngle = 180 - $angle;

            $angleRad = $angle*pi()/180;

            //x,y coordinate of line coming off of horizontal line
            $x = $circleRadius*cos($angleRad);
            $y = -$circleRadius*sin($angleRad);

            $imageDimensions = $this->getSVGCanvasDimensions();
            $translateX = 0;
            $translateY = -50;
            $this->imageSVG .= '<line x1="'.(0+$translateX).'" y1="'.($imageDimensions["height"]/2-$translateY).'" x2="'.($imageDimensions["width"]+$translateX).'" y2="'.($imageDimensions["height"]/2-$translateY).'" fill = "white" style="stroke: black; stroke-width: 2;"></line>';
            $this->imageSVG .= '<line x1="'.($imageDimensions["width"]/2+$translateX).'" y1="'.($imageDimensions["height"]/2-$translateY).'" x2="'.($imageDimensions["width"]/2+$x+$translateX).'" y2="'.($imageDimensions["height"]/2+$y-$translateY).'" fill = "white" style="stroke: black; stroke-width: 2;"></line>';
            $this->imageSVG .= '<foreignObject x="'.($imageDimensions["width"]/2+$translateX-80).'" y="'.($imageDimensions["height"]/2-$translateY - 40).'" width="50" height="50"><div xmlns="http://www.w3.org/1999/xhtml" style="font-family:Times; font-size:30px">\(x\)</div></foreignObject>';
            $this->imageSVG .= '<foreignObject x="'.($imageDimensions["width"]/2+$translateX+60).'" y="'.($imageDimensions["height"]/2-$translateY - 40).'" width="60" height="40"><div xmlns="http://www.w3.org/1999/xhtml" style="font-family:Times; font-size:30px">\('.($angle).'^{\\circ}\)</div></foreignObject>';    




            $this->setQuestion('\mathrm{Find \ angle \ } x');
            $this->setAnswer($findAngle);
        }

        function generateImage($id, $num){
            global $createdByTutor;
            $imageFile = '';
            $imageDimensions = $this->getSVGCanvasDimensions();
            $imageSVG = $this->imageSVG;
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



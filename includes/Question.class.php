<?php

class Question{
    private $question;
    private $answer;
    private $blurb = [];
    //private $imageSVG = ''; Change the architecture to utilize this

    function getSVGCanvasDimensions(){
        global $questionImageDimensions;
        return $questionImageDimensions;
    }

    function setQuestion($question){
        $this->question = $question;
    }

    function setAnswer($answer){
        $this->answer = $answer;
    }

    function getQuestion(){
        return $this->question;
    }

    function getAnswer(){
        return $this->answer;
    }

    function getBlurb(){
        return $this->blurb;
    }

    function addToBlurb($stringToAdd){
        array_push($this->blurb, $stringToAdd);
    }

    function generateImage($id, $num){
        return ''; 
    }

    function shuffle_assoc(&$array) {
        $keys = array_keys($array);

        shuffle($keys);

        foreach($keys as $key) {
            $new[$key] = $array[$key];
        }

        $array = $new;

        return true;
    }

    function calculateFactorial($n){
        $fact = 1;
        $start = $n;
        while($start >= 1){
            $fact *= $start;
            $start--;
        }
        return $fact;
    }

    //function that returns a string based on coefficient and term
    //I was just tired of having to always put in the different cases for each question
    function getCoefficientString($coefficient, $term, $displayPositiveSign=True){
        if($coefficient < 0){
            if($coefficient==-1){
                if($term == ''){
                    return "-1";
                } else {
                    return "-$term";
                }
            } else {
                return "$coefficient"."$term";
            }
        } else if ($coefficient > 0){
            if($coefficient==1){
                if($displayPositiveSign){
                    if($term==""){
                        return "+1";
                    } else {
                        return "+$term";
                    }
                } else {
                    if($term==""){
                        return "1";
                    } else {
                        return "$term";
                    }
                }
            } else {
                if($displayPositiveSign){
                    return "+$coefficient"."$term";
                } else {
                    return "$coefficient"."$term";
                }
            }
        } else if ($coefficient == 0){
            return "";
        }
    }

    function float2rat($n, $latexFormat = True, $tolerance = 1.e-6) {
        $negative = false;
        if($n < 0){
            $n = $n * (-1);
            $negative = true;
        }
        if($n == 0) return "0";
        $h1=1; $h2=0;
        $k1=0; $k2=1;
        $b = 1/$n;
        do {
            $b = 1/$b;
            $a = floor($b);
            $aux = $h1; $h1 = $a*$h1+$h2; $h2 = $aux;
            $aux = $k1; $k1 = $a*$k1+$k2; $k2 = $aux;
            $b = $b-$a;
        } while (abs($n-$h1/$k1) > $n*$tolerance);

        if($latexFormat){   
            if($negative){
                if($k1 == 1){
                    return '-'.$h1;
                }
                return "-\\frac{".$h1."}{".$k1."}";
            } else {
                if($k1 == 1){
                    return $h1;
                }
                return "\\frac{".$h1."}{".$k1."}";
            }
        } else {
            return "$h1/$k1";
        }
    }

    function generateSVGPolygon($numVertices, $imageDimensions, $radius, $translationX = 0, 
                                $translationY = 0, $localRotationZ = 0){
        $pointsString = '';
        $pointCoordinates = [];
        $n = $numVertices;

        //Position each vertex around origin point (0,0) top left hand corner of the canvas
        if ($n%2==0){
            for ($i = 0; $i < $n; $i++){
                array_push($pointCoordinates, [round($radius * cos((-$n*pi() + 2*pi() + 4*pi()*$i)/(2*$n)+$localRotationZ)), 
                                            round($radius * sin((-$n*pi() + 2*pi() + 4*pi()*$i)/(2*$n)+$localRotationZ))]);
            }
        } else {
            for ($i = 0; $i < $n; $i++){
                array_push($pointCoordinates, [round($radius * cos((-$n*pi() + 4*pi()*$i)/(2*$n)+$localRotationZ)), 
                                            round($radius * sin((-$n*pi() + 4*pi()*$i)/(2*$n)+$localRotationZ))]);
            }
        }

        // translate the vertices to the centre of the canvas
        for($i = 0; $i < count($pointCoordinates); $i++){
            $pointCoordinates[$i][0] += $imageDimensions["width"]/2 + $translationX;
            $pointCoordinates[$i][1] += $imageDimensions["height"]/2 + $translationY;
        }

        for($i = 0; $i < count($pointCoordinates)-1; $i++){
            $pointsString .= $pointCoordinates[$i][0].','.$pointCoordinates[$i][1].' ';
        }
        $pointsString .= $pointCoordinates[count($pointCoordinates)-1][0].','.$pointCoordinates[count($pointCoordinates)-1][1];
        //echo $pointsString;
        return '<polygon points="'.$pointsString.'" fill = "white" 
                    style="stroke: black; stroke-width: 3;"></polygon>';
    }

    function generateCartesianGrid($imageDimensions, $translationX, $translationY, $spacingUnits, $includeSubGrid){
        //Grid Layout Settings
        $mainAxesStrokeThickness = 0.5;
        $subAxesStrokeThickness = 0.08;
        
        $verticalSubAxesSpacing = $spacingUnits;
        $horizontalSubAxesSpacing = $spacingUnits;

        //The string to be sent to the Question Class
        $gridString = '';
        if($includeSubGrid){
            $count = 1;
            while(round($imageDimensions["width"]/2 + $verticalSubAxesSpacing * $count + $translationX*$spacingUnits) < $imageDimensions["width"]){
                $gridString .= '<line x1="'.round($imageDimensions["width"]/2 + $verticalSubAxesSpacing * $count + $translationX*$spacingUnits).'" y1="0" x2="'.round($imageDimensions["width"]/2 + $verticalSubAxesSpacing * $count + $translationX*$spacingUnits).'" y2="'.$imageDimensions["height"].'" fill = "white" style="stroke: grey; stroke-width: '.$subAxesStrokeThickness.';"></line>';
                $count++;
            }
            $count = 1;
            while(round($imageDimensions["width"]/2 - $verticalSubAxesSpacing * $count + $translationX * $spacingUnits) > 0){
                $gridString .= '<line x1="'.round($imageDimensions["width"]/2 - $verticalSubAxesSpacing * $count + $translationX * $spacingUnits).'" y1="0" x2="'.round($imageDimensions["width"]/2 - $verticalSubAxesSpacing * $count + $translationX * $spacingUnits).'" y2="'.$imageDimensions["height"].'" fill = "white" style="stroke: grey; stroke-width: '.$subAxesStrokeThickness.';"></line>';
                $count++;
            }
            $count = 1;
            while(round($imageDimensions["height"]/2 + $horizontalSubAxesSpacing * $count - $translationY * $spacingUnits) < $imageDimensions["height"]){
                $gridString .= '<line x1="0" y1="'.round($imageDimensions["height"]/2 + $horizontalSubAxesSpacing * $count - $translationY * $spacingUnits).'" x2="'.$imageDimensions["width"].'" y2="'.round($imageDimensions["height"]/2 + $horizontalSubAxesSpacing * $count - $translationY * $spacingUnits).'" fill = "white" style="stroke: grey; stroke-width: '.$subAxesStrokeThickness.';"></line>';
                $count++;
            }
            $count = 1;
            while(round($imageDimensions["height"]/2 - $horizontalSubAxesSpacing * $count - $translationY * $spacingUnits) > 0){
                $gridString .= '<line x1="0" y1="'.round($imageDimensions["height"]/2 - $horizontalSubAxesSpacing * $count - $translationY * $spacingUnits).'" x2="'.$imageDimensions["width"].'" y2="'.round($imageDimensions["height"]/2 - $horizontalSubAxesSpacing * $count - $translationY * $spacingUnits).'" fill = "white" style="stroke: grey; stroke-width: '.$subAxesStrokeThickness.';"></line>';
                $count++;
            }
        }
        $gridString .= '<line x1="'.round($imageDimensions["width"]/2+$translationX * $spacingUnits).'" y1="0" x2="'.round($imageDimensions["width"]/2+$translationX * $spacingUnits).'" y2="'.$imageDimensions["height"].'" fill = "white" style="stroke: grey; stroke-width: '.$mainAxesStrokeThickness.';"></line>';
        $gridString .= '<line x1="0" y1="'.round($imageDimensions["height"]/2-$translationY * $spacingUnits).'" x2="'.$imageDimensions["width"].'" y2="'.round($imageDimensions["height"]/2-$translationY * $spacingUnits).'" fill = "white" style="stroke: grey; stroke-width: '.$mainAxesStrokeThickness.';"></line>';
        return $gridString;
    }

    function drawGraphFunction($imageDimensions, $functions, $xSpacing=10, $includeGrid=True, $includeSubGrid=True, $translateGridX=0, $translateGridY=0, $spacingUnits = 40, $strokeWidth = 2){
        $SVGCode = '';
        foreach($functions as $function){
            if($function["type"]=="circle"){
                $SVGCode .= $this->generateCartesianGrid($imageDimensions, $translateGridX, $translateGridY, $spacingUnits, $includeSubGrid);
                $SVGCode .= '<circle cx="'.($function["a"] * $spacingUnits + $imageDimensions["width"]/2).'" cy="'.(-$function["b"] * $spacingUnits + $imageDimensions["height"]/2).'" r="'.($function["c"] * $spacingUnits).'" fill="none" style="stroke: black; stroke-width: '.$strokeWidth.';" />';
                continue;
            }
            foreach($function["ranges"] as $range){
                $pointsString='';
                $xValues = [];
                $yValues = [];
                //$spacing = round($xSpacingProportion * $imageDimensions["width"]);
                for($i=$range[1]*$spacingUnits; $i>$range[0] * $spacingUnits;$i-=$xSpacing){
                    $xValue = ($includeGrid)? $i + $imageDimensions["width"]/2 + $translateGridX * $spacingUnits: $i + $imageDimensions["width"]/2;
                    $yValue = ($includeGrid)? $this->graphFunction($function, $i, $spacingUnits) + $imageDimensions["height"]/2 - $translateGridY * $spacingUnits : $this->graphFunction($function, $i, $spacingUnits) + $imageDimensions["height"]/2;
                    if(abs($yValue) > 2 * $imageDimensions["height"] || is_nan($yValue)) continue;
                    array_push($xValues, round($xValue));
                    array_push($yValues, round($yValue));
                }
                //$yValues = array_reverse($yValues);
                for($i=0; $i < count($xValues);$i++){
                    $pointsString .= $xValues[$i].','.$yValues[$i].' ';
                }
                $pointsString .= $xValues[count($xValues)-1].','.$yValues[count($yValues)-1];
                if($function["type"]=="log_e") $pointsString .= ' '.($xValues[count($xValues)-1]-$xSpacing/4).',400 ';
                $SVGCode .= '<polyline points="'.$pointsString.'" fill="none" style="stroke: black; stroke-width: '.$strokeWidth.';" />';
            }
        }
        if($includeGrid){
            $SVGCode .= $this->generateCartesianGrid($imageDimensions, $translateGridX, $translateGridY, $spacingUnits, $includeSubGrid).$SVGCode;
        }
        return $SVGCode;
    }

    function drawTable($imageDimensions, $xTranslation, $yTranslation, $titles, $indices, $data, $height, $width, $xCentre){
        $SVG = '';
        $numIndices = count($indices);
        $numData = count($data);
        $boxHeight = $height / $numIndices;
        $boxWidth = $width / 2;

        $SVG .= '<rect x="'.($imageDimensions["width"]/2+$xTranslation).'" y="'.($imageDimensions["height"]/2-$yTranslation).'" width="'.$width.'" height="'.$height.'" style="fill:white; stroke-width:2; stroke:black;"/>';
        $SVG .= '<line x1="'.($imageDimensions["width"]/2+$xTranslation+$width/2).'" y1="'.($imageDimensions["height"]/2-$yTranslation).'" x2="'.($imageDimensions["width"]/2+$xTranslation+$width/2).'" y2="'.($imageDimensions["height"]/2-$yTranslation+$height).'" fill = "white" style="stroke: black; stroke-width: 2;"></line>';
        $SVG .= '<line x1="'.($imageDimensions["width"]/2+$xTranslation).'" y1="'.($imageDimensions["height"]/2-$yTranslation + $height/5).'" x2="'.($imageDimensions["width"]/2+$xTranslation+$width).'" y2="'.($imageDimensions["height"]/2-$yTranslation + $height/5).'" fill = "white" style="stroke: black; stroke-width: 2;"></line>';
        $SVG .= '<foreignObject x="105" y="35" width="100" height="100"><div xmlns="http://www.w3.org/1999/xhtml" style="font-family:Times; font-size:30px">\(x\)</div></foreignObject>';
        $SVG .= '<foreignObject x="245" y="35" width="100" height="100"><div xmlns="http://www.w3.org/1999/xhtml" style="font-family:Times; font-size:30px">\(y\)</div></foreignObject>';
        for($i=0; $i < $numData; $i++){
            $SVG .= '<foreignObject x="105" y="'.((($imageDimensions["height"]/2-$yTranslation + $height/5) + ($height-$height/5)/($numData)*$i)).'" width="100" height="100"><div xmlns="http://www.w3.org/1999/xhtml" style="font-family:Times; font-size:30px">\('.$indices[$i].'\)</div></foreignObject>';
            $SVG .= '<foreignObject x="245" y="'.((($imageDimensions["height"]/2-$yTranslation + $height/5) + ($height-$height/5)/($numData)*($i))).'" width="100" height="100"><div xmlns="http://www.w3.org/1999/xhtml" style="font-family:Times; font-size:30px">\('.$data[$i].'\)</div></foreignObject>';
            $SVG .= '<line x1="'.($imageDimensions["width"]/2+$xTranslation).'" y1="'.(($imageDimensions["height"]/2-$yTranslation + $height/5) + ($height-$height/5)/($numData)*$i).'" x2="'.($imageDimensions["width"]/2+$xTranslation+$width).'" y2="'.(($imageDimensions["height"]/2-$yTranslation + $height/5) + ($height-$height/5)/($numData)*$i).'" fill = "white" style="stroke: black; stroke-width: 2;"></line>';
        }

        return $SVG;

    }

    //This has 2 independent variables. So a 2x2 table
    // [       ][title1 ][title2 ][total  ]
    // [title3 ][data1  ][data2  ][total1 ]
    // [title4 ][data3  ][data4  ][total2 ]
    // [total  ][total3 ][total4 ][total5 ]
    function drawProbabilityTable($imageDimensions, $xTranslation, $yTranslation, $width, $height, $titles, $data){
        $SVG = '';
        $title1 = $titles[0];
        $title2 = $titles[1];
        $title3 = $titles[2];
        $title4 = $titles[3];
        $data1 = $data[0];
        $data2 = $data[1];
        $data3 = $data[2];
        $data4 = $data[3];
        $total1 = $data1 + $data2;
        $total2 = $data3 + $data4;
        $total3 = $data1 + $data3;
        $total4 = $data2 + $data4;
        $total5 = $total1 + $total2;

        $row1 = ['',$title1, $title2, 'Total'];
        $row2 = [$title3,$data1, $data2, $total1];
        $row3 = [$title4,$data3, $data4, $total2];
        $row4 = ['Total',$total3, $total4, $total5];

        $SVG .= '<rect x="'.($imageDimensions["width"]/2+$xTranslation).'" y="'.($imageDimensions["height"]/2-$yTranslation).'" width="'.$width.'" height="'.$height.'" style="fill:white; stroke-width:1; stroke:black;"/>';
        for($i=1; $i < 4; $i++){
            $SVG .= '<line x1="'.($imageDimensions["width"]/2+$xTranslation).'" y1="'.(($imageDimensions["height"]/2-$yTranslation) + ($height/4)*$i).'" x2="'.($imageDimensions["width"]/2+$xTranslation+$width).'" y2="'.(($imageDimensions["height"]/2-$yTranslation) + ($height/4)*$i).'" fill = "white" style="stroke: black; stroke-width: 1;"></line>';
            $SVG .= '<line x1="'.($imageDimensions["width"]/2+$xTranslation + $width/4*$i).'" y1="'.(($imageDimensions["height"]/2-$yTranslation)).'" x2="'.($imageDimensions["width"]/2+$xTranslation + $width/4*$i).'" y2="'.(($imageDimensions["height"]/2-$yTranslation)+$height).'" fill = "white" style="stroke: black; stroke-width: 1;"></line>';
        }
        for($i=0; $i < 4; $i++){
            $SVG .= '<text x="'.($imageDimensions["width"]/2+$xTranslation + $width/50 + $width/4*$i).'" y="'.(95).'"  >'.$row1[$i].'</text>';
            $SVG .= '<text x="'.($imageDimensions["width"]/2+$xTranslation + $width/50 + $width/4*$i).'" y="'.(155).'"  >'.$row2[$i].'</text>';
            $SVG .= '<text x="'.($imageDimensions["width"]/2+$xTranslation + $width/50 + $width/4*$i).'" y="'.(225).'"  >'.$row3[$i].'</text>';
            $SVG .= '<text x="'.($imageDimensions["width"]/2+$xTranslation + $width/50 + $width/4*$i).'" y="'.(290).'"  >'.$row4[$i].'</text>';
        }

        return $SVG;
    }

    //This has 2 independent variables. So a 2x2 table
    //     /\
    //    A  B
    //   /\  /\
    //  C  DE  F
    function drawProbabilityTree($imageDimensions, $xTranslation, $yTranslation, $width, $height, $titles, $data){
        $SVG = '';
        $A = $titles[0];
        $B = $titles[1];
        $C = $titles[2];
        $D = $titles[3];
        $E = $titles[4];
        $F = $titles[5];
        $probA = $data[0];
        $probB = $data[1];
        $probC = $data[2];
        $probD = $data[3];
        $probE = $data[4];
        $probF = $data[5];
        
        $SVG .= '<line x1="'.($imageDimensions["width"]/2).'" y1="100" x2="'.($imageDimensions["width"]/2-50).'" y2="150" fill = "white" style="stroke: black; stroke-width: 1;"></line>';
        $SVG .= '<text x="'.($imageDimensions["width"]/2-60).'" y="180">A</text>';
        $SVG .= '<text x="'.($imageDimensions["width"]/2-80).'" y="120">'.$probA.'</text>';
        $SVG .= '<line x1="'.($imageDimensions["width"]/2).'" y1="100" x2="'.($imageDimensions["width"]/2+50).'" y2="150" fill = "white" style="stroke: black; stroke-width: 1;"></line>';
        $SVG .= '<text x="'.($imageDimensions["width"]/2+40).'" y="180">B</text>';
        $SVG .= '<text x="'.($imageDimensions["width"]/2+40).'" y="120">'.$probB.'</text>';

        $SVG .= '<line x1="'.($imageDimensions["width"]/2-50).'" y1="200" x2="'.($imageDimensions["width"]/2-50-30).'" y2="250" fill = "white" style="stroke: black; stroke-width: 1;"></line>';
        $SVG .= '<text x="'.($imageDimensions["width"]/2-100).'" y="280">C</text>';
        $SVG .= '<text x="'.($imageDimensions["width"]/2-130).'" y="240">'.$probC.'</text>';
        $SVG .= '<line x1="'.($imageDimensions["width"]/2-50).'" y1="200" x2="'.($imageDimensions["width"]/2-50+30).'" y2="250" fill = "white" style="stroke: black; stroke-width: 1;"></line>';
        $SVG .= '<text x="'.($imageDimensions["width"]/2-30).'" y="280">D</text>';
        $SVG .= '<text x="'.($imageDimensions["width"]/2-10).'" y="240">'.$probD.'</text>';

        //$SVG .= '<line x1="'.($imageDimensions["width"]/2+50).'" y1="200" x2="'.($imageDimensions["width"]/2+50-30).'" y2="250" fill = "white" style="stroke: black; stroke-width: 1;"></line>';
        //$SVG .= '<text x="'.($imageDimensions["width"]/2+10).'" y="280">E</text>';
        //$SVG .= '<line x1="'.($imageDimensions["width"]/2+50).'" y1="200" x2="'.($imageDimensions["width"]/2+50+30).'" y2="250" fill = "white" style="stroke: black; stroke-width: 1;"></line>';
        //$SVG .= '<text x="'.($imageDimensions["width"]/2+80).'" y="280">F</text>';

        return $SVG;
    }

    function graphFunction($f, $xValue, $spacingUnits){
        if($f["type"]=="line"){
            //ax+b
            return -($f["a"] * $xValue/$spacingUnits + $f["b"])*$spacingUnits;
        } else if($f["type"]=="quadratic"){
            //a(x + b/2a)^2 + c - b^2/4a probably didn't need to do this because other code does translations for me
            //return -($f["a"] * pow($xValue/$spacingUnits + ($f["b"]/(2*$f["a"])),2)+
            //                        ($f["c"]-(pow($f["b"],2)/(4*$f["a"]))))*$spacingUnits;
            //ax^2 + bx + c
            return -($f["a"] * pow($xValue/$spacingUnits, 2) + $f["b"] * $xValue/$spacingUnits + $f["c"] ) * $spacingUnits;
        } else if($f["type"]=="cubic"){
            //a(x-b)(x-c)(x-d)
            return -($f["a"]*($xValue/$spacingUnits - $f["b"])*($xValue/$spacingUnits- $f["c"])*($xValue/$spacingUnits-$f["d"]))*$spacingUnits;
        } else if($f["type"]=="exp"){
            //ae^(bx-c)
            return -($f["a"] * exp($f["b"]*$xValue/$spacingUnits - $f["c"]))*$spacingUnits;
        } else if($f["type"]=="exp_n"){
            //ab^(cx-d)
            return -($f["a"] * pow($f["b"], $f["c"]*$xValue/$spacingUnits - $f["d"]))*$spacingUnits;
        } else if($f["type"]=="log_e"){
            //a*ln(bx-c)
            return -($f["a"]*log($f["b"]*$xValue/$spacingUnits-$f["c"]))*$spacingUnits;
        } else if($f["type"]=="sin"){
            //a*sin(bx-c)
            return -($f["a"]*sin($f["b"]*$xValue/$spacingUnits - $f["c"]))*$spacingUnits;
        } else if($f["type"]=="cos"){
            //a*cos(bx-c)
            return -($f["a"]*cos($f["b"]*$xValue/$spacingUnits - $f["c"]))*$spacingUnits;
        } else if($f["type"]=="tan"){
            //a*tan(bx-c)
            return -($f["a"]*tan($f["b"]*$xValue/$spacingUnits - $f["c"]))*$spacingUnits;
        } else if($f["type"]=="normaldis"){
            //a = mu, b = sigma
            //(exp(-(x-mu)^2/(2*sigma^2)))/(sigma*sqrt(2*pi))
            return -(exp(-pow($xValue/$spacingUnits - $f["a"],2)/(2*pow($f["b"],2)))/($f["b"])*sqrt(2*pi())) * $spacingUnits;
        }
    }

    function getRandomNaturalNumber($range=100){
        return random_int(0,$range);
    }

    function getRandomIntegerNumber($range=100){
        $positive = random_int(0,1);
        if($positive){
            return random_int(0,$range);
        } else {
            return -random_int(0,$range);
        }
    }

    function getRandomRationalNumber($numeratorRange=99, $denominatorRange=999, $latex=True){
        $decimal = random_int(0,1);
        $numerator = random_int(1,$numeratorRange);
        $denominator = random_int(2,$denominatorRange);
        if($latex && !$decimal){
            return "\\frac{".$numerator."}{".$denominator."}";
        } else {
            return round($numerator/$denominator,5);
        }
    }

    function getRandomIrrationalNumber($latex=True){
        $types = ["exponential","root","pi"];
        $type = $types[random_int(0,count($types)-1)];

        if($type == "exponential"){
            if($latex){
                return "e";
            } else {
                return exp();
            }
        } else if($type == "root"){
            if($latex){
                return "\sqrt{2}";
            } else {
                return sqrt(2);
            }
        } else if($type == "pi"){
            if($latex){
                return "\pi";
            } else {
                return pi();
            }
        }
    }

    function getRandomRealNumber($latex=True){
        $types = ["natural","integer","rational","irrational"];
        $type = $types[random_int(0,count($types)-1)];

        if($type == "natural"){
            return $this->getRandomNaturalNumber();
        } else if($type == "integer"){
            return $this->getRandomIntegerNumber();
        } else if($type == "rational"){
            return $this->getRandomRationalNumber($latex);
        } else if($type == "irrational"){
            return $this->getRandomIrrationalNumber($latex);
        }
    }

    function getRandomComplexNumber($latex=True){
        $real = $this->getRandomRealNumber();
        $imaginary = $this->getRandomRealNumber();

        return "$real"."$imaginary";
    }

}

?>
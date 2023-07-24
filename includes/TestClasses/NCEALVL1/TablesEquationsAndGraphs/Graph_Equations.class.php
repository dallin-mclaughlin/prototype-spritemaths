<?php

    class GraphEquations extends Question{   
        private $functions = [];
        private $translateGridY = 0;
        
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
            $gradient = (random_int(0,1))?random_int(2,4):-random_int(2,4);
            if(random_int(0,1)){
                $gradient = 1 / $gradient;
            }
            $intercept = (random_int(0,1))?random_int(2,6):-random_int(2,6);
            array_push($this->functions, ["type"=>"line","ranges"=>[[-10,10]],"a"=>$gradient,"b"=>$intercept]);

            $this->setQuestion('\mathrm{ Determine \ the \ equation \ of \ the \ graph }');

            $equation = 'y='.$this->float2rat($gradient).'x+'.$intercept;
            $equation = str_replace("+-","-", $equation);
            $this->setAnswer($equation);
        }

        function quadraticGraph(){
            $value1 = (random_int(0,1))?random_int(1,6):-random_int(1,6);
            $value2 = (random_int(0,1))?random_int(1,6):-random_int(1,6);
            $a = 1;
            $b = $value1 + $value2;
            $c = $value1 * $value2;
            array_push($this->functions, ["type"=>"quadratic","ranges"=>[[-10,10]],"a"=>$a,"b"=>$b,"c"=>$c]);

            $this->setQuestion('\mathrm{ Determine \ the \ equation \ of \ the \ graph }');
            
            $equation = 'y= \left(x+'.$value1.' \right)\left(x+'.$value2.'\right)';
            $equation = str_replace("+-","-", $equation);
            $this->setAnswer($equation);
        }

        function exponentialGraph(){
            $base = random_int(2,5);
            $a = 1;
            $b = $base;
            $c = 1;
            $d = 0;
            array_push($this->functions, ["type"=>"exp_n","ranges"=>[[-10,10]],"a"=>$a,"b"=>$b,"c"=>$c,"d"=>$d]);
            $this->translateGridY = -5;

            $this->setQuestion('\mathrm{ Determine \ the \ equation \ of \ the \ graph }');
            
            $equation = 'y='.$base.'^{x}';
            $equation = str_replace("+-","-", $equation);
            $this->setAnswer($equation);
        }

        function generateImage($id, $num){
            global $createdByTutor;
            $imageFile = '';
            $imageDimensions = $this->getSVGCanvasDimensions();
            $imageSVG = $this->drawGraphFunction($imageDimensions = $imageDimensions, 
                            $functions = $this->functions, 
                            $xSpacing = 3, $includeGrid = True, $includeSubGrid = True,
                            $translateGridX = 0, $translateGridY = $this->translateGridY, $spacingUnits = 30);
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



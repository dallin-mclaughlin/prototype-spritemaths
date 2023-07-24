<?php

    class PythagorasQuestion extends Question{
        
        private $answer;
        private $question;

        private $sideA;
        private $sideB;
        private $sideC;
        private $sideAnswer;

        private $ran;
        //Hypotenuse always needs to be larger than the other sides. Need to code this in

        private $blurb = [];

        function __construct(){
            $this->Question();
            $this->Answer();
        }

        function getBlurb(){
            return $this->blurb;
        }
        
        function generateSides(){
            $this->ran = random_int(0,2);

            $firstNum = random_int(1,12);
            $secondNum = random_int(1,12);
            if($this->ran==2){
                $this->sideA = $firstNum;
                $this->sideB = $secondNum;
                
                $this->sideC = round(sqrt($this->sideA**2 + $this->sideB**2),2);
                $this->sideAnswer = $this->sideC;
            } else if($this->ran==1){
                if($firstNum > $secondNum){
                    $this->sideC = $firstNum;
                    $this->sideA = $secondNum;
                } else {
                    $this->sideC = $secondNum;
                    $this->sideA = $firstNum;
                }
                if($this->sideA==$this->sideC) $this->sideC += 1;

                $this->sideB = round(sqrt(abs($this->sideC**2 - $this->sideA**2)),2);
                $this->sideAnswer = $this->sideB;
            } else {        
                if($firstNum > $secondNum){
                    $this->sideC = $firstNum;
                    $this->sideB = $secondNum;
                } else {
                    $this->sideC = $secondNum;
                    $this->sideB = $firstNum;
                }
                if($this->sideB==$this->sideC) $this->sideC += 1;

                $this->sideA = round(sqrt(abs($this->sideC**2 - $this->sideB**2)),2);
                $this->sideAnswer = $this->sideA;
            }

        }

        function generateImage($id, $num){
            global $createdByTutor;
            $imageFile = '';
            $neededRef = '';

            if($this->ran == 2){
                $textA = max($this->sideA, $this->sideB);
                $textB = min($this->sideA, $this->sideB);
                $textHyp = 'x';
            } else if($this->ran == 1){
                $textA = min($this->sideA, $this->sideC);
                $textB = 'x';
                $textHyp = max($this->sideA, $this->sideC);
            } else {
                $textA = 'x';
                $textB = min($this->sideB, $this->sideC);
                $textHyp = max($this->sideB, $this->sideC);
            }

            
            $imageSVG = '<polygon points="100,150 300,50 300,150" fill = "white" style="stroke: black; stroke-width: 3;"></polygon>';
            $imageSVG .= '<rect x = "280" y = "130" width ="20" height ="20" fill = "white" style="stroke: black; stroke-width: 3;"></rect>';
            $imageSVG .= '<foreignObject x="295" y="100" width="50" height="100"><div xmlns="http://www.w3.org/1999/xhtml" style="font-family:Times; font-size:15px">\('.$textB.'\)</div></foreignObject>';
            $imageSVG .= '<foreignObject x="180" y="160" width="50" height="100"><div xmlns="http://www.w3.org/1999/xhtml" style="font-family:Times; font-size:15px">\('.$textA.'\)</div></foreignObject>';
            $imageSVG .= '<foreignObject x="175" y="70" width="50" height="100"><div xmlns="http://www.w3.org/1999/xhtml" style="font-family:Times; font-size:15px">\('.$textHyp.'\)</div></foreignObject>';
            
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
        

        function Question(){
            $this->generateSides();
            $this->question = '\mathrm{\ Find \ the \ value \ of \ } x \mathrm{\ to \ 2 \ d.p.}';
        }

        function Answer(){
            $this->answer = $this->sideAnswer;
        }

        function getQuestion(){
            return $this->question;
        }

        function getAnswer(){
            return $this->answer;
        }
    }
?>
<?php


    class DifferentiationPolynomialsQuestion extends Question{
        
        private $answer;

        private $poly = '';
        private $polyDif = '';

        private $vars = '';
        private $vars1 = 'uv';
        private $vars2 = 'xy';
        private $vars3 = 'ts';
        private $varsArray = array();

        private $coefficientsArray = array();
        private $difCoefficientsArray = array();

        private $blurb = [];

        function __construct(){
            $this->Question();
            $this->Answer();
        }

        function getBlurb(){
            return $this->blurb;
        }
        
        function generateImage($id, $num){
            return ''; 
        }

        function fillArray(){
            $this->varsArray[] = $this->vars1; 
            $this->varsArray[] = $this->vars2;           
            $this->varsArray[] = $this->vars3;
        }

        function pickVars() {
            $n = random_int(0,2);
            $this->vars = $this->varsArray[$n];
        }

        function generateCoefficients(){
            $n = random_int(1,5);
            for($i = 0; $i < $n; $i++){
                array_push($this->coefficientsArray, random_int(-9,9));
            }
        }

        function generateDifCoefficients(){
            $n = count($this->coefficientsArray);
            for($i = 1; $i < $n; $i++){
                array_push($this->difCoefficientsArray, $this->coefficientsArray[$i]*$i);
            }
        }

        function simplifyPolynomials(){
            for($i = count($this->coefficientsArray)-1; $i >= 0; $i--){
                if($this->coefficientsArray[$i] != '0'){
                    if($this->coefficientsArray[$i] == '1'){
                        $this->poly .= $this->vars[0].'^'.$i.'+';
                    } else if ($this->coefficientsArray[$i] == '-1'){
                        $this->poly .= '-'.$this->vars[0].'^'.$i.'+';
                    } else {
                        $this->poly .= $this->coefficientsArray[$i].$this->vars[0].'^'.$i.'+';
                    }
                }
            }

            for($i = count($this->difCoefficientsArray)-1; $i >= 0; $i--){
                if($this->difCoefficientsArray[$i] != '0'){
                    if($this->difCoefficientsArray[$i] != '1'){
                        $this->polyDif .= $this->difCoefficientsArray[$i].$this->vars[0].'^'.$i.'+';
                    } else {
                        if($i==0){
                            $this->polyDif .= $this->difCoefficientsArray[$i];
                        } else {
                            $this->polyDif .= $this->vars[0].'^'.$i.'+';
                        }
                    }
                }
            }

            $order = array($this->vars[0].'^0', '^1');
            $this->poly = str_replace($order,"", $this->poly);
            $this->polyDif = str_replace($order,"", $this->polyDif);

            while(substr($this->poly,-1)=='+'|| substr($this->poly,-1)=='-'){
                $this->poly = substr($this->poly, 0, -1);
            }
            while(substr($this->polyDif,-1)=='+'||substr($this->polyDif,-1)=='-'){
                $this->polyDif = substr($this->polyDif, 0, -1);
            }

            $this->poly = str_replace("+-","-", $this->poly);
            $this->polyDif = str_replace("+-","-", $this->polyDif);

        }

        function Question(){
            $this->fillArray();
            $this->pickVars();
            $this->generateCoefficients();
            $this->generateDifCoefficients();
            //$this->generatePolynomial();
            //$this->generateDifPolynomial();
            $this->simplifyPolynomials(); 
            if($this->poly == '') {
                $this->poly = '0';
            }
        }

        function Answer(){
            if($this->polyDif==''){
                $this->polyDif = '0';
            }
            $this->answer = $this->polyDif;
        }

        function getQuestion(){
            return "\mathrm{\ Differentiate \ } ".$this->poly." \mathrm{ \ with 
                    \ respect \ to \ } ".$this->vars[0];
        }

        function getAnswer(){
            return $this->answer;
        }
    }
?>
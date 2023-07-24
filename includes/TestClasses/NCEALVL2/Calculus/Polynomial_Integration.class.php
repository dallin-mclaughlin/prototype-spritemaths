<?php

    class IntegrationPolynomialsQuestion extends Question{
        
        private $answer;

        private $poly = '';
        private $polyInteg = '';

        private $vars = '';
        private $vars1 = 'uv';
        private $vars2 = 'xy';
        private $vars3 = 'ts';
        private $varsArray = array();

        private $coefficientsArray = array();
        private $integCoefficientsArray = array();

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

        function float2rat($n, $tolerance = 1.e-6) {
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

            return "$h1/$k1";
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
            $n = random_int(1,3);
            for($i = 0; $i < $n; $i++){
                array_push($this->coefficientsArray, random_int(0,9));
            }
        }

        function generateIntegCoefficients(){
            $n = count($this->coefficientsArray);
            array_push($this->integCoefficientsArray, 'C');
            for($i = 0; $i < $n; $i++){
                array_push($this->integCoefficientsArray, $this->float2rat($this->coefficientsArray
                [$i]/($i+1)));
            }
        }

        function simplifyPolynomials(){
            //print_r($this->coefficientsArray);
            //print_r($this->integCoefficientsArray);
            for($i = 0; $i < count($this->coefficientsArray); $i++){
                if(strpos($this->coefficientsArray[$i], '/')){
                    if(strlen($this->coefficientsArray[$i])>1&&substr($this->coefficientsArray[$i], -2,2)=='/1'){
                        $this->coefficientsArray[$i] = str_replace('/1', '', $this->coefficientsArray[$i]);
                    } else {
                        $this->coefficientsArray[$i] = str_replace('/', '}{', $this->coefficientsArray[$i]);
                        $this->coefficientsArray[$i] = '\frac{'.$this->coefficientsArray[$i].'}';
                    }
                }
            }

            //echo 'first';
            //print_r($this->coefficientsArray);

            for($i = 0; $i < count($this->integCoefficientsArray); $i++){
                if(strpos($this->integCoefficientsArray[$i], '/')){
                    if(strlen($this->integCoefficientsArray[$i])>1&&substr($this->integCoefficientsArray[$i], -2,2)=='/1'){
                        $this->integCoefficientsArray[$i] = str_replace('/1', '', $this->integCoefficientsArray[$i]);
                    } else {
                        $this->integCoefficientsArray[$i] = str_replace('/', '}{', $this->integCoefficientsArray[$i]);
                        $this->integCoefficientsArray[$i] = '\frac{'.$this->integCoefficientsArray[$i].'}';
                    }
                }
            }

            //echo 'first';
            //print_r($this->integCoefficientsArray);

            for($i = count($this->coefficientsArray)-1; $i >= 0; $i--){
                if($this->coefficientsArray[$i] != '0'){
                    if($this->coefficientsArray[$i] != '1'){
                        $this->poly .= $this->coefficientsArray[$i].$this->vars[0].'^'.$i.'+';
                    } else {
                        if($i!=0){
                            $this->poly .= $this->vars[0].'^'.$i.'+';
                        } else {
                            $this->poly .= '1+';
                        }
                    }
                }
            }

            //echo 'second'.$this->poly;

            for($i = count($this->integCoefficientsArray)-1; $i >= 0; $i--){
                if($this->integCoefficientsArray[$i] != '0'){
                    if($this->integCoefficientsArray[$i] != '1'){
                        $this->polyInteg .= $this->integCoefficientsArray[$i].$this->vars[0].'^'.$i.'+';
                    } else {
                        if($i==0){
                            $this->polyInteg .= $this->integCoefficientsArray[$i];
                        } else {
                            $this->polyInteg .= $this->vars[0].'^'.$i.'+';
                        }
                    }
                }
            }

            //echo 'second'.$this->polyInteg;

            $order = array($this->vars[0].'^0', '^1');
            $this->poly = str_replace($order,"", $this->poly);
            $this->polyInteg = str_replace($order,"", $this->polyInteg);

            //echo 'third'.$this->poly;
            //echo 'third'.$this->polyInteg;

            while(substr($this->poly,-1)=='+'||substr($this->poly,-1)=='-'){
                $this->poly = substr($this->poly, 0, -1);
            }
            while(substr($this->polyInteg,-1)=='+'||substr($this->polyInteg,-1)=='-'){
                $this->polyInteg = substr($this->polyInteg, 0, -1);
            }

            $this->poly = str_replace("+-","-", $this->poly);
            $this->polyInteg = str_replace("+-","-", $this->polyInteg);

            //echo 'fourth'.$this->poly;
            //echo 'fourth'.$this->polyInteg;
        }

        function Question(){
            $this->fillArray();
            $this->pickVars();
            $this->generateCoefficients();
            $this->generateIntegCoefficients();
            $this->simplifyPolynomials(); 
        }

        function Answer(){
            if($this->poly == ''){
                $this->polyInteg = $this->vars[0].'+C';
            }
            $this->answer = $this->polyInteg;
        }

        function getQuestion(){
            return "\mathrm{ \ } \int ".$this->poly." \ \mathrm{d} ".$this->vars[0];
            //return " \int_{4}^{5} ";
        }

        function getAnswer(){
            return $this->answer;
        }
    }
?>
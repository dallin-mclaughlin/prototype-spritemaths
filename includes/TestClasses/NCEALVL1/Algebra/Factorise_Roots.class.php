<?php

    class FactoriseRoots extends Question{
        private $answer;
        private $question;

        private $root1;
        private $root2;

        private $blurb = ["\mathrm{Give \ your \ answer \ as \ an \ expression}"];

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

        function generateRoots(){
            $this->root1 = (random_int(0,1))?random_int(1,8):-random_int(1,8);
            $this->root2 = (random_int(0,1))?random_int(1,8):-random_int(1,8);
        }

        function Question(){
            $this->generateRoots();
            $this->question = "\mathrm{\ Determine \ the \ roots \ of \ the \ quadratic \ } x^2";
            if($this->root1 + $this->root2 == 0){
                if($this->root1*$this->root2<0){
                    $this->question .= $this->root1*$this->root2;
                } else {
                    $this->question .= '+'.$this->root1*$this->root2;
                }
            } else {
                if($this->root1 + $this->root2 < 0){
                    if($this->root1*$this->root2<0){
                        $this->question .= ($this->root1+$this->root2==-1)?'-x'.$this->root1*$this->root2:($this->root1+$this->root2).'x'.$this->root1*$this->root2;
                    } else {
                        $this->question .= ($this->root1+$this->root2==-1)?'-x+'.$this->root1*$this->root2:($this->root1+$this->root2).'x+'.$this->root1*$this->root2;
                    }
                } else {
                    if($this->root1*$this->root2<0){
                        $this->question .= ($this->root1+$this->root2==1)?'+x'.$this->root1*$this->root2:'+'.($this->root1+$this->root2).'x'.$this->root1*$this->root2;
                    } else {
                        $this->question .= ($this->root1+$this->root2==1)?'+x+'.$this->root1*$this->root2:'+'.($this->root1+$this->root2).'x+'.$this->root1*$this->root2;
                    }
                }
            }
        }

        function Answer(){
            if($this->root1==$this->root2){
                $this->answer = -$this->root1."";
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
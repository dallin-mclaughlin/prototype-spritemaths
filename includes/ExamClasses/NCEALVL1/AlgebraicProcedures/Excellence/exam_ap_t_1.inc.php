<?php
    class algebraT1Question
    {
        private $question;
        private $answer;

        private $expression;

        private $equations = [  ['\left(y^2-x^2\right)a=bt-v','y=\sqrt{x^2+\frac{bt-v}{a}}','a=\frac{bt-v}{y^2-x^2}','v=bt-(y^2-x^2)a','x=\sqrt{y^2-\frac{bt-v}{a}}','t=\frac{(y^2-x^2)a+v}{t}','b=\frac{\left(y^2-x^2\right)a+v}{t}'],
                                ['ax^2-z=\sqrt{vt+1}','z=ax^2-\sqrt{vt+1}','a=\frac{\sqrt{vt+1}+z}{x^2}','x=\sqrt{\sqrt{vt+1}+z}{a}','v=\frac{\left(ax^2-z\right)^2-1}{t}','t=\frac{\left(ax^2-z\right)^2-1}{v}'],
                                ['\frac{c}{p}\sqrt{a-b}=x','c=\frac{px}{\sqrt{a-b}}','p=\frac{c\sqrt{a-b}}{x}','a=\left(\frac{px}{c}\right)^2+b','b=a-\left(\frac{px}{c}\right)^2'],
                                ['\frac{n}{m}(a+bt)=(v-m)^2','n=\frac{m\left(v-m\right)^2}{a+bt}','m=\frac{n\left(a+bt\right)}{\left(v-m\right)^2}','a=\frac{m}{n}\left(v-m\right)^2-bt','b=\frac{m\left(v-m\right)^2-an}{nt}','t=\frac{m\left(v-m\right)^2-an}{nb}'],
                                ['y-2=\sqrt{\frac{v^2(x+9)}{q}}','y=\sqrt{\frac{v^2\left(x+9\right)^2}{q}}+1','v=\sqrt{q\left(y-2\right)^2}{x+9}','x=\frac{q}{v^2}\left(y-2\right)^2-9','q=\frac{v^2\left(x+9\right)}{\left(y-2\right)^2}'],
                                ['\frac{v}{q}=\frac{p-1}{v}','q=\frac{v^2}{p-1}','p=\frac{v^2}{q}+1','v=\sqrt{q\left(p-1\right)}'],
                                ['a\frac{b}{c}=(z-x)^2','a=\frac{c}{b}\left(z-x\right)^2','b=\frac{c}{a}\left(z-x\right)^2','c=a\frac{b}{\left(z-x\right)^2}','z=\sqrt{a\frac{b}{c}}+x','x=-\sqrt{a\frac{b}{c}}+z'],
                                ['x^2+\left(b+1\right)x+b=9x-2','b=\frac{9x-2}{x+1}-x'],
                                ['\frac{5x+2y}{z}=\frac{abc}{\sqrt{b}}','z=\frac{\sqrt{b}\left(5x+2y\right)}{abc}','x=\frac{zabc-2y\sqrt{b}}{5\sqrt{b}}','y=\frac{zabc-5x\sqrt{b}}{2\sqrt{b}}','b=\left(\frac{5x+2y}{zac}\right)^2','a=\frac{5x+2y}{\sqrt{b}cz}','c=\frac{5x+2y}{\sqrt{b}az}'],
                                ['\sqrt{5^x}=3^z\cdot9^z','z=\frac{log_{3}\sqrt{5^x}}{3}','x=log_{5}3^{6z}']];

        private $equation_num;
        private $arrangement_num;

        private $blurb = [];

        function __construct(){
            $this->Question();
            $this->Answer();
        }
        
        function getBlurb(){
            return $this->blurb;
        } 
        
        function generateRandomNumbers()
        {
            $this->equation_num = random_int(0,count($this->equations)-1);
            $this->arrangement_num = random_int(1,count($this->equations[$this->equation_num])-1);
        }
        
        function generateImage($id, $num)
        {
            return '';
        }

        function Question()
        {
            $this->generateRandomNumbers();
            $this->question = $this->equations[$this->equation_num][0];
            $this->blurb[] = '\mathrm{Rearrange \ this \ equation \ so \ that \ } '.substr($this->equations[$this->equation_num][$this->arrangement_num],0,1).' \mathrm{ \ is \ the \ subject}';
        }

        function Answer()
        {
            $this->answer = $this->equations[$this->equation_num][$this->arrangement_num];
        }

        function toQuestion()
        {
            return $this->question;
        }

        function toAnswer()
        {
            return $this->answer;
        }
    }
?>
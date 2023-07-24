<?php

class SimultaneousEquations extends Question{

    function __construct(){
        //[Ax + By = E]
        //[Cx + Dy = F]
        $A = random_int(0,8);
        $B = random_int(1,5);
        $C = random_int(1,8);
        $D = random_int(0,5);

        $E = random_int(0,8);
        $F = random_int(9,15);

        $equation1 = [$A, $B, $E];
        $equation2 = [$C, $D, $F];

        $latexEquation1 = $this->latexLinearEquation($equation1);
        $latexEquation2 = $this->latexLinearEquation($equation2);

        [$x,$y] = $this->solve($equation1, $equation2);

        $this->addToBlurb("\mathrm{ Given \ } ".$latexEquation1.' \mathrm{ \ and \ } '.$latexEquation2);
        $this->setQuestion("\mathrm{ Solve \ for \ } x \mathrm{ \ and } \ y");
        $this->setAnswer($x.",".$y);
    }

    function latexLinearEquation($equation){
        $latex = '';
        if($equation[0]==0){
            $latex .= $equation[1].'y='.$equation[2];
            return $latex;
        } else if($equation[1]==0){
            $latex .= $equation[0].'x='.$equation[2];
            return $latex;
        }

        $ran = random_int(0,2);

        if($ran == 0){
            $latex .= $equation[0].'x+'.$equation[1].'y='.$equation[2];
        } else if($ran == 1){
            $latex .= $equation[1].'y='.$equation[2].'+'.-$equation[0].'x';
        } else if($ran == 2){
            if($equation[0]!=1){
                $latex .= 'y=\\frac{'.$equation[2].'}{'.$equation[1].'}+\\frac{'.-$equation[0].'}{'.$equation[1].'}x';
            } else {
                $latex .= 'y='.$equation[2].'+'.-$equation[0].'x';
            }
        }

        $latex = str_replace("+-","-", $latex);
        return $latex;
    }

    function solve($equation1, $equation2){
        $det = 1/($equation1[0]*$equation2[1]-$equation1[1]*$equation2[0]);

        $x = $det * ($equation2[1]*$equation1[2]-$equation1[1]*$equation2[2]);
        $y = $det * ($equation1[0]*$equation2[2]-$equation2[0]*$equation1[2]);

        return [$this->float2rat($x), $this->float2rat($y)];
    }

}


?>
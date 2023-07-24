<?php

    class ContinuousData extends Question{   
        
        function __construct(){
            $dataString = '[';
            $data = [];
            $numData = random_int(10,18);
            for($i = 0; $i < $numData; $i++){
                array_push($data, random_int(0,100)/10);
            }
            
            for($i = 0; $i < count($data)-1; $i++){
                $dataString .= $data[$i].', \ ';
            }
            $dataString .= $data[count($data)-1].']';

            sort($data);
            $this->addToBlurb($dataString);
            $this->setQuestion('\mathrm{Find \ the \ median \ of \ the \ dataset}');
            if(count($data)%2==0){
                $index1 = count($data)/2;
                $index2 = $index1 - 1;
                $this->setAnswer(($data[$index1]+$data[$index2])/2);
            } else {
                $index = floor(count($data)/2);
                $this->setAnswer($data[$index]);
            }

        }

    }

?>



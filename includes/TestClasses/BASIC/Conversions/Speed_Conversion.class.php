<?php

    class SpeedConversionQuestion extends Question{

        private $initialUnit;
        private $units = ['kmhr^{-1}','ms^{-1}','kms^{-1}','mhr^{-1}'];

        function __construct(){

            $unitsConversions = ['kmhr^{-1}'=>3.6,'ms^{-1}'=>1,'kms^{-1}'=>0.001,
                                'mhr^{-1}'=>3600];

            $this->initialUnit = $this->units[random_int(0,count($this->units)-1)];
            $finalUnit = $this->getFinalUnit($this->initialUnit);

            $initialValue = $this->getRandomValue($this->initialUnit);
            $finalValue = $initialValue*$unitsConversions[$finalUnit]/$unitsConversions[$this->initialUnit];

            $this->setQuestion('\mathrm{Convert \ }'.$initialValue.'\mathrm{ '.$this->initialUnit.
                                ' \ into  \ '.$this->getUnitWord($finalUnit).'}');
            $this->setAnswer($finalValue);
        }

        function getRandomValue($unit)
        {
            if($unit == "kmhr^{-1}"){
                return random_int(1,9999) / 10;
            } else if($unit == "ms^{-1}"){
                return random_int(1,99);
            } else if($unit == "kms^{-1}"){
                return random_int(1,99) / 100;
            } else if($unit == "mhr^{-1}"){
                return random_int(1,99) * 100;
            }
        }

        function getUnitWord($unit){
            if($unit == "kmhr^{-1}"){
                return 'kilometres \ per \ hour';
            } else if($unit == "ms^{-1}"){
                return 'metres \ per \ second';
            } else if($unit == "kms^{-1}"){
                return 'kilometres \ per \ second'; 
            } else if($unit == "mhr^{-1}"){
                return 'metres \ per \ hour';
            }
        }

        function getFinalUnit($initialUnit){
            $finalUnit = $this->units[random_int(0,count($this->units)-1)];
            while($finalUnit == $this->initialUnit){
                $finalUnit = $this->units[random_int(0,count($this->units)-1)];
            }
            return $finalUnit;
        }
       
    }

?>
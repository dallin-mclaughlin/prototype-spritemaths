<?php

    class TimeConversionQuestion extends Question{

        private $initialUnit;
        private $units = ['ms','s','min','hr'];

        function __construct(){

            $unitsConversions = ['ms'=>0.001,'s'=>1,'min'=>60,'hr'=>3600];

            $this->initialUnit = $this->units[random_int(0,count($this->units)-1)];
            $finalUnit = $this->getFinalUnit($this->initialUnit);

            $initialValue = $this->getRandomValue($this->initialUnit);
            $finalValue = $initialValue*$unitsConversions[$this->initialUnit]/$unitsConversions[$finalUnit];

            $this->setQuestion('\mathrm{Convert \ }'.$initialValue.'\mathrm{ '.$this->initialUnit.
                                ' \ into  \ '.$this->getUnitWord($finalUnit).'}');
            $this->setAnswer($finalValue);
        }

        function getRandomValue($unit)
        {
            if($unit == "ms"){
                return random_int(1,99) * 10;
            } else if($unit == "s"){
                return random_int(1,9999) / 10;
            } else if($unit == "min"){
                return random_int(1,9) * 60;
            } else if($unit == "hr"){
                return random_int(1,9);
            }
        }

        function getUnitWord($unit){
            if($unit == "ms"){
                return 'milliseconds';
            } else if($unit == "s"){
                return 'seconds';
            } else if($unit == "min"){
                return 'minutes';
            } else if($unit == "hr"){
                return 'hours';
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
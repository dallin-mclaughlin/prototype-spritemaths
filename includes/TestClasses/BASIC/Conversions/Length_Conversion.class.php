<?php

    class LengthConversionQuestion extends Question{

        private $initialUnit;
        private $units = ['nm','μm','mm','cm','m','km'];

        function __construct(){

            $unitsConversions = ['nm'=>0.000000001,'μm'=>0.000001,'mm'=>0.001,'cm'=>0.01,
                                'm'=>1,'km'=>1000];

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
            if($unit == "nm"){
                return random_int(1,99) * 100;
            } else if($unit == "μm"){
                return random_int(1,999) * 100;
            } else if($unit == "mm"){
                return random_int(1,9) * 100;
            } else if($unit == "cm"){
                return random_int(1,99) * 10;
            } else if($unit == "m"){
                return random_int(1,99);
            } else if($unit == "km"){
                return random_int(1,9);
            }
        }

        function getUnitWord($unit){
            if($unit == "nm"){
                return 'nanometres';
            } else if($unit == "μm"){
                return 'micrometres';
            } else if($unit == "mm"){
                return 'millimetres';
            } else if($unit == "cm"){
                return 'centimetres';
            } else if($unit == "m"){
                return 'metres';
            } else if($unit == "km"){
                return 'kilometres';
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
<?php

    class MassConversionQuestion extends Question{

        private $initialUnit;
        private $units = ['μg','mg','g','kg','t'];

        function __construct(){

            $unitsConversions = ['μg'=>pow(10,-6),'mg'=>pow(10,-3),'g'=>1,
                                'kg'=>pow(10,3),'t'=>pow(10,6)];

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
            if($unit == "μg"){
                return random_int(1,999) * 100;
            } else if($unit == "mg"){
                return random_int(1,999) * 100;
            } else if($unit == "g"){
                return random_int(1,9999) / 100;
            } else if($unit == "kg"){
                return random_int(1,9999) / 10;
            } else if($unit == "t"){
                return random_int(1,90) / 10;
            }
        }

        function getUnitWord($unit){
            if($unit == "μg"){
                return 'micrograms';
            } else if($unit == "mg"){
                return 'miligrams';
            } else if($unit == "g"){
                return 'grams';
            } else if($unit == "kg"){
                return 'kilograms';
            } else if($unit == "t"){
                return 'tonnes';
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
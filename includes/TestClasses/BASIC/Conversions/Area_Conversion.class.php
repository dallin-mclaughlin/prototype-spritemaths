<?php

    class AreaConversionQuestion extends Question{

        private $initialUnit;
        private $units = ['μm^{2}','mm^{2}','cm^{2}','m^{2}','km^{2}'];

        function __construct(){

            $unitsConversions = ['μm^{2}'=>pow(0.000001,2),'mm^{2}'=>pow(0.001,2),
                                'cm^{2}'=>pow(0.01,2),'m^{2}'=>1,'km^{2}'=>pow(1000,2)];

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
            if($unit == "μm^{2}"){
                return random_int(1,999) * 100;
            } else if($unit == "mm^{2}"){
                return random_int(1,9) * 100;
            } else if($unit == "cm^{2}"){
                return random_int(1,99) * 10;
            } else if($unit == "m^{2}"){
                return random_int(1,99);
            } else if($unit == "km^{2}"){
                return random_int(1,9);
            }
        }

        function getUnitWord($unit){
            if($unit == "μm^{2}"){
                return 'squared-micrometres';
            } else if($unit == "mm^{2}"){
                return 'squared-millimetres';
            } else if($unit == "cm^{2}"){
                return 'squared-centimetres'; 
            } else if($unit == "m^{2}"){
                return 'squared-metres';
            } else if($unit == "km^{2}"){
                return 'squared-kilometres';
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
<?php

    class VolumeConversionQuestion extends Question{

        private $initialUnit;
        private $units = ['μm^{3}','mm^{3}','cm^{3}','mL','L','m^{3}','km^{3}'];

        function __construct(){

            $unitsConversions = ['μm^{3}'=>pow(0.000001,3),'mm^{3}'=>pow(0.001,3),
                                'cm^{3}'=>pow(0.01,3),'mL'=>pow(0.01,3),
                                'L'=>pow(0.1,3),'m^{3}'=>1,'km^{3}'=>pow(1000,3)];

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
            if($unit == "μm^{3}"){
                return random_int(1,999) * 100;
            } else if($unit == "mm^{3}"){
                return random_int(1,9) * 100;
            } else if($unit == "cm^{3}"){
                return random_int(1,9) * 100;
            } else if($unit == "mL"){
                return random_int(1,9) * 10;
            } else if($unit == "L"){
                return random_int(1,90);
            } else if($unit == "m^{3}"){
                return random_int(1,99);
            } else if($unit == "km^{3}"){
                return random_int(1,9);
            }
        }

        function getUnitWord($unit){
            if($unit == "μm^{3}"){
                return 'cubed-micrometres';
            } else if($unit == "mm^{3}"){
                return 'cubed-millimetres';
            }  else if($unit == "cm^{3}"){
                return 'cubed-centimetres';
            } else if($unit == "mL"){
                return 'mililitres';
            } else if($unit == "L"){
                return 'litres';
            } else if($unit == "m^{3}"){
                return 'cubed-metres';
            } else if($unit == "km^{3}"){
                return 'cubed-kilometres';
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
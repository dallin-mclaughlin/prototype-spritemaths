<?php

    class CurrencyConversionQuestion extends Question{

        private $initialUnit;
        private $units = ['£','€','US \ $','AUS \ $','NZ \ $','¥'];

        function __construct(){
            $bitCoin = ['₿'=>0.0000252];
            $unitsConversions = ['£'=>0.80,'€'=>0.94,'US \ $'=>1,'AUS \ $'=>1.38,
                                'NZ \ $'=>1.53,'¥'=>6.61];

            $this->initialUnit = $this->units[random_int(0,count($this->units)-1)];
            $finalUnit = $this->getFinalUnit($this->initialUnit);

            $initialValue = $this->getRandomValue($this->initialUnit);
            $finalValue = $initialValue*$unitsConversions[$finalUnit]/$unitsConversions[$this->initialUnit];
            $this->addCurrencyListing($unitsConversions);
            $this->setQuestion('\mathrm{Convert \ '.$this->initialUnit.' }'.$initialValue.
                                ' \mathrm{ \ into  \ '.$this->getUnitWord($finalUnit).' \ '.
                                $finalUnit.'}');
            $this->setAnswer($finalValue);
        }

        function getRandomValue($unit)
        {
            if($unit == "₿"){
                return random_int(1,9) * 100;
            } else if($unit == "£"){
                return random_int(1,999) * 100;
            } else if($unit == "€"){
                return random_int(1,999) / 100;
            } else if($unit == "US \ $"){
                return random_int(1,999) / 10;
            } else if($unit == "AUS \ $"){
                return random_int(1,999) / 10;
            } else if($unit == "NZ \ $"){
                return random_int(1,999) / 10;
            } else if($unit == "¥"){
                return random_int(1,999) / 10;
            }
        }

        function getUnitWord($unit){
            if($unit == "₿"){
                return 'Bitcoins';
            } else if($unit == "£"){
                return 'British \ Pounds';
            } else if($unit == "€"){
                return 'Euros';
            } else if($unit == "US \ $"){
                return 'US \ dollars';
            } else if($unit == "AUS \ $"){
                return 'Australian \ dollars';
            } else if($unit == "NZ \ $"){
                return 'NZ \ dollars';
            } else if($unit == "¥"){
                return 'Chinese \ Yuan';
            } 
        }

        function getFinalUnit($initialUnit){
            $finalUnit = $this->units[random_int(0,count($this->units)-1)];
            while($finalUnit == $this->initialUnit){
                $finalUnit = $this->units[random_int(0,count($this->units)-1)];
            }
            return $finalUnit;
        }

        function addCurrencyListing($currencyUnits){
            $symbols = array_keys($currencyUnits);
            foreach($symbols as $symbol){
                $this->addToBlurb('1 \ \mathrm{ US \ dollar \ } = \mathrm{ \ '.$symbol.'}'.
                number_format($currencyUnits[$symbol],2));
            }
        }
       
    }

?>
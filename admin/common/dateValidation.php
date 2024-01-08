<?php
    function validate_date($date, $min="", $max=""){
        $d = date_create($date);

        $dateMin = date_create($min);

        $dateMax = date_create($max);

        if(!empty($min)){
            $diff = date_diff($dateMin,$d);
            $diffInt = (int)$diff->format("%R%a");
            if($diffInt < 0){
                return "-1";
            }
        }elseif(!empty($max)){
            $diff = date_diff($d,$dateMax);
            $diffInt = (int)$diff->format("%R%a");
            if($diffInt < 0){
                return "1";
            }
        }
            return 0;
        
        
    }

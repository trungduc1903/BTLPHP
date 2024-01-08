<?php
function validate_name($name){
    $nameErr = "";
    if(strlen($name) < 2){
        $nameErr = "Không được ít hơn 2 kí tự";
    }elseif(strlen($name) > 20){
        $nameErr = "Không được quá 20 kí tự";
    }
    return $nameErr;
}
<?php
function validate_phone($phone){
    $phoneErr = "";    
    $phonePattern = "/^0\d{9}$/";
    $isPhoneVaild = preg_match($phonePattern, $phone);
    if(!$isPhoneVaild){
        $phoneErr = "Số điện thoại không hợp lệ";
    }
    return $phoneErr;
}
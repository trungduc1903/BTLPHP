<?php
function validate_email($email){
    $emailErr = "";   
    $emailPattern = "/^\S+@\S+\.\S+$/";
    $isEmailValid = preg_match($emailPattern, $email);
    if(!$isEmailValid){
        $emailErr = "Email không hợp lệ";
    }
    return $emailErr;
}
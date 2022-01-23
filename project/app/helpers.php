<?php
function getPaymentDay($payment){
if(empty($payment->created_at))return "None";
return $payment->created_at->format('j') ;
}

function getPaymentMonth($payment){
    if(empty($payment->created_at))return "None";
return $payment->created_at->format('M') ;

}

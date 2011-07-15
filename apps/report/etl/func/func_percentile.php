<?php

// test run
//$data = "1,2,3,4,5,6,7,8,9,10,11";
//$percentile = "10,25,50,75,90";
//
//$parr = explode(",",$percentile);
//foreach($parr as $p){
//	echo percentile($data, $p);
//	echo "\n";
//}


function percentile($data, $percentile){
	$data		=explode(",",$data);
	
	$newdata=array();
	foreach($data as $number){
		if((float)$number>0){
			array_push($newdata,$number);	
		}		
	}
	$data = $newdata;
	
	sort($data);
    if( 0 < $percentile && $percentile < 1 ) { 
        $p = $percentile; 
    }else if( 1 < $percentile && $percentile <= 100 ) { 
        $p = $percentile * .01; 
    }else { 
        return ""; 
    } 
    
    $count = count($data); 
    
    $nInteger = (int)(($count-1)*$p);
    $nDecimal = ($count-1)*$p - $nInteger;
    $result = (1-$nDecimal)*$data[$nInteger] + $nDecimal * $data[$nInteger + 1];
     
	return $result;
}

?>
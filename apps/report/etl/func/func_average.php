<?php 
function average($data,$length){
	$data		=explode(",",$data);
	
	$newdata=array();
	foreach($data as $number){
		if((float)$number>0){
			array_push($newdata,$number);	
		}		
	}
	$data = $newdata;
	$result = array_sum($data) / count($data);
    
	$length = (int)$length;
	$fmt = "%.".$length."f";
	
	return sprintf($fmt,$result);
}
?>
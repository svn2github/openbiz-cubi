<?php 

// test run
//$arrX = "1,2,3,4,5,6,7,8,9,10";
//$arrY = "10,2,3,4,5,6,7,8,9,10";
//
//
//foreach($arrX as $x){
//	echo $x." : ";
//	echo exponential_regression($arrX, $arrY, $x);
//	echo "\n";
//}

function exponential_regression($arrX, $arrY, $x){
		$arrX		=explode(",",$arrX);
		$arrY		=explode(",",$arrY);
	$nCount = count($arrX);
	for($k=0;$k<$nCount;$k++){
		$xin[$k] = $arrX[$k];
		$yin[$k] = log($arrY[$k]);
	}
	$sumx= $sumy=$sumx2=$sumxy=0;
	for($i=0;$i<$nCount;$i++){
		$sumx = $sumx + $xin[$i];
		$sumy = $sumy + $yin[$i];		
		$sumx2 = $sumx2 + pow($xin[$i],2);		
		$sumxy = $sumxy + $xin[$i] * $yin[$i];		
	}
	$a = ($nCount * $sumxy - $sumx * $sumy) / ($nCount * $sumx2 - pow($sumx,2));
	$b = ($sumy - $a * $sumx ) / $nCount;
	$result = (int)(exp($b) * exp($a*$x));
	return $result;
	
}
?>
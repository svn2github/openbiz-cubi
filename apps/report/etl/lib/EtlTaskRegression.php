<?php 
class EtlTaskRegression extends EtlTask
{
	
    public function transform(){
    	$destArr = array();
    	foreach($this->m_SourceArr as $row){
    		//transform each data records
    		$destRow = array();
    		foreach($this->m_Transforms as $trans){
    		//load transform rules
    			$source = $trans["ATTRIBUTES"]["SOURCE"]?$trans["ATTRIBUTES"]["SOURCE"]:$trans["SOURCE"];
    			$dest 	= $trans["ATTRIBUTES"]["DEST"]?$trans["ATTRIBUTES"]["DEST"]:$trans["DEST"];
    			$func	= $trans["ATTRIBUTES"]["FUNCTION"]?$trans["ATTRIBUTES"]["FUNCTION"]:$trans["FUNCTION"];
    		
    			    			
    			$func_param_arr = array();
    			preg_match("/(.*?)\((.*?)\)/si",$func,$match);
    			$func_name = $match[1];
    			$func_param = $match[2];
    			//prepare data source parameters supports for multi columns parameters
    			$source_arr = explode(",",$source);
    			foreach($source_arr as $source_col){
    				 array_push($func_param_arr,$row[$source_col]);
    			}
    			//prepare user defined parameters
    			$func_user_param_arr = explode(",",$func_param);
    			foreach($func_user_param_arr as $param){
    				if($param!=''){
    					array_push($func_param_arr,$param);
    				}
    			}  

    			$range_min = array_shift($func_param_arr);
    			$range_max = array_shift($func_param_arr);
    			for($i=$range_min; $i<=$range_max; $i++){
    				if($func){
	    				$new_array = $func_param_arr;
	    				array_push($new_array,$i);
	    				$destArr[$i][$dest] = call_user_func_array($func_name,$new_array);
    				}elseif(preg_match("/INDEX/s",$source)){
    					$destArr[$i][$dest] = (int)$i;
    				}else{    					    					
    					$col_val = $func_param_arr[0];
    					$destArr[$i][$dest] = $col_val;
    				}
	    			if(defined("CLI")){
							echo ".";
					}
    			}
    			
    			
    		}
    		
    	}
    	$this->m_DestArr = $destArr;
    }    
	
	
}
?>
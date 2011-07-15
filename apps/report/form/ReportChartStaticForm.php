<?php 
include_once "ReportChartForm.php";
class ReportChartStaticForm extends ReportChartForm
{
    public function draw()
    {
    	$img_name = str_replace("ReportChartStaticForm","ReportChartForm",$this->m_Name);
		$img = "<img src=\"".PUBLIC_UPLOAD_URL."/report/".$img_name.".jpg\" />";
 
    	return $img;
    }
}
?>
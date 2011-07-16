function ExportCharts(){
	for(i=0;i<charts.length;i++){
		var chartObject = getChartFromId(charts[i]);
		if( chartObject.hasRendered() ){
			chartObject.exportChart({exportFormat:'JPG'});		
		}
	}
}

function FC_Exported(objRtn){
	if(objRtn.statusCode==1){

			location.href=Openbiz.appUrl+"/bin/exportReportPDF.php?id="+reportId;

	}
}
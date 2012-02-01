Openbiz.StatChartForm = Class.create(Openbiz.Form,
{	
	collectData: function($super)
    {
    	formData = $super() + "&_form=" + this.selectedId
    						+ "&_chart_type=" +  document.getElementById('sel_charttype_hidden').value    						
    						;
        return formData;
    }
});
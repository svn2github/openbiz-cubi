/**
 * Openbiz Folder Tree class
 */

Openbiz.GridForm = Class.create(Openbiz.Form,
{
	initialize: function($super, name, subForms)
    {
        $super(name, subForms);
        this.grid = $j(jq(name+"_data_table"));
		this.selectedId = "";
    },
    DeleteRecord: function(paramArray, options)
    {
    	alertMsg = "Are you sure you want to delete the selected record(s)?";
        if (!confirm(alertMsg))
    		return;
    	this.CallFunction("deleteRecord", paramArray, options);
    },
    collectData: function($super)
    {
    	this.selectedId = this.grid.jqGrid('getGridParam', 'selrow');
		if (this.selectedId == null) this.selectedId = "";
		formData = $super() + "&_selectedId=" + this.selectedId;
        return formData;
    }
});
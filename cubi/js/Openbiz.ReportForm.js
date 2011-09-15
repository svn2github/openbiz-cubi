/**
 * Openbiz Report Form class
 */
Openbiz.ReportForm = Class.create(Openbiz.TableForm,
{
	initialize: function($super, name, subForms)
    {
        $super(name, subForms);
        var formNameArr = this.name.split("--"); 
        this.baseFormName = formNameArr[0];
        this.reportFormName = formNameArr[1];
    },
	CallFunction: function(method, paramArray, options)
    {
        Openbiz.activeForm = this;
    	type = (options && options['type']) ? options['type'] : Openbiz.ActionType.RPC;
        this.actionType = type;
        paramArray.unshift(this.baseFormName, method);	//paramArray.unshift(this.name, method);

        // does AJAX call
        var url = Openbiz.appHome;
        var formData = this.collectData();
        if (type == Openbiz.ActionType.RPC || type == Openbiz.ActionType.DIALOG)
            requestString = Openbiz.Util.composeRequestString("RPCInvoke", paramArray);
        else
            requestString = Openbiz.Util.composeRequestString("Invoke", paramArray);
        url += "?"+requestString;
        if (options && options['evthdl'])
            url += "&__this="+options['evthdl'];
	   
        // append report form name in url
        url += "&__form="+this.reportFormName;
        
	    switch (type) {
            case Openbiz.ActionType.PAGE:
                Openbiz.Net.loadPage(url); break;
            case Openbiz.ActionType.FORM:
                this.submit(url); break;
            case Openbiz.ActionType.POPUP:
                Openbiz.Window.openPopup(url); break;
            default:
            	if (this.hasFileToUpload())
            		Openbiz.Net.postFile(url, this.form, formData);
            	else
            		Openbiz.Net.post(url, formData);
        }
    }
});

/**
 * Openbiz Pivot Form class
 */
Openbiz.PivotForm = Class.create(Openbiz.Form,
{
	initialize: function($super, name, subForms)
    {
        $super(name, subForms);
	},
    renderPivot: function(paramArray, options)
    {
        if (validatePivotForm()) {
			this.form.setAttribute("target", "_blank");
            this.CallFunction("renderPivot", paramArray, options);
		}
    }
});

// validation of input
var pivotInputs = ['fld_colfld1','fld_colfld2','fld_rowfld1','fld_rowfld2','fld_rowfld3','fld_datafld1'];
function validatePivotInputs(elem) {
    for(i=0; i<pivotInputs.length; i++) {
        if (elem.id != pivotInputs[i] && elem.value != '' && elem.value == $(pivotInputs[i]).value) {
            select_list_selected_index = elem.selectedIndex;
            text = elem.options[select_list_selected_index].text
            alert("Please select a different field other than '"+text+"'");
            elem.value='';
        }
    }
}
function validatePivotForm() {
    if ($('fld_colfld1').value == '' || $('fld_rowfld1').value == '' || $('fld_datafld1').value == '') {
        alert("Please select a valid column field, row fields and data field for pivot table.");
        return false;
    }
    return true;
}
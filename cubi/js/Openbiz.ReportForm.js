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

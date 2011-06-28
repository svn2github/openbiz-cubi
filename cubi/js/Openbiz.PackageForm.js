/**
 * Openbiz Report Form class
 */
Openbiz.PackageForm = Class.create(Openbiz.Form,
{
    install: function(paramArray, options)
    {
    	this.CallFunction("install", paramArray, options);
        
        this.CallFunction("getProgress", paramArray, options);
    },
    updateFields: function(fieldValues)
    {
        fieldValues.each(function(tgt_ctnt) {
            // special handling progress_bar update
            if (tgt_ctnt.target == 'progress_bar') {
                inst_info = tgt_ctnt.content.split('|', 4);
                state = inst_info[0];                 
                log = inst_info[1]; 
                //$(tgt_ctnt.target).innerHTML = log;
                if (state == 'Install' ||
                	state == 'Download' ||
                	state == 'Wait' 
                	) {
                    setTimeout(function() {
                        Openbiz.CallFunction("package.local.form.PackageInstallerForm.getProgress()",null);
                    }, 1000);
                }
            }
            else {
                $(tgt_ctnt.target).value = tgt_ctnt.content;
            }
        });
    }
});
/*
Openbiz.ProgressBar = 
{
    set: function(divid, progress)
    {
        // set progress value and text
        $(divid).value = progress;
        // draw the bar
        
        // wait 1 second to check again
        setTimeout(function() {
                alert('again');
                Openbiz.CallFunction("package.local.form.PackageLocalDetailForm.getProgress()",null);
            }, 1000);
    },
    get: function(divid)
    {
        // get progress value
        return $(divid).value;
    }
}
*/

/*
function periodicXHReqCheck() {
    xhReq = Ajax.getTransport();
    alert('check xhReq '+xhReq.responseText);
    $("progressDiv").innerHTML += xhReq.responseText;
    $("progressDiv").show();
}*/
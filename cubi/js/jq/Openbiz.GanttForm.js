/**
 * Openbiz Sticky Form class
 */
Openbiz.GanttForm = Class.create(Openbiz.Form,
{
	SelectRecord: function(paramArray)
    {
    	var recordId = paramArray[0];
    	if(typeof forceSelectRecord !='undefined'){
    		if(forceSelectRecord!=true){
    			if (recordId == this.selectedId) return;
    		}
    	}else{
    		if (recordId == this.selectedId) return;
    	}

        // switch highlight and call server select
        if(this.selectedId){
            this.lastSelectedId = this.selectedId;
        }
        this.selectedId = recordId;
        
        //if (this.subForms == null)
        //	return;
        this.CallFunction("selectRecord", [recordId]);
    },
	collectData: function($super)
    {
    	formData = $super() + "&_selectedId=" + this.selectedId
    						+ "&start_time=" +  this.start_time
    						+ "&duration=" + this.duration
    						+ "&move_child=" + this.move_child
    						;
        return formData;
    }
});
/**
 * Openbiz Folder Tree class
 */

Openbiz.FolderTree = Class.create(Openbiz.Form,
{
	initialize: function($super, name, subForms)
    {
        $super(name, subForms);
        //this.initTree(name);
    },
    deleteNode: function(paramArray, options)
    {
    	node = $j.tree_focused().selected;
    	if (node == null) {
    		alert("Please select a node first");
    		return;
    	}
        nodeid = node.attr('value');
        nodename = node.attr('rel');
        ok = confirm("Are you sure you want to delete '"+nodename+"'?");
        if (ok)
            this.CallFunction("deleteNode", paramArray, options);
        else
        	return;
    },
    updateFields: function(fieldValues)
    {
    	nodeid = this.name+"_"+fieldValues['id'];
    	name = fieldValues['name'];
    	action = fieldValues['action'];
    	if (action == 'rename')
    		$(nodeid).down('a').update(name);
    	else {
    		$j.tree_focused().refresh($(nodeid));
    		if ($(nodeid))
    			$j.tree_focused().select_branch($(nodeid));
    	}
    },
    select: function(id)
    {
        nodeid = this.name+"_"+id;
        if ($(nodeid))
    		$j.tree_focused().select_branch($(nodeid));
    },
    CallFunction: function($super, method, paramArray, options)
    {
    	node = $j.tree_focused().selected;
    	if (node == null) {
    		alert("Please select a node first");
    		return;
    	}
        nodeid = node.attr('value');
        paramArray.push(nodeid);
        $super(method, paramArray, options);
    }
});
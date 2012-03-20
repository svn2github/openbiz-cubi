<?php $name = $this->name; ?>

<script language="JavaScript">
 minus = new Image();
 minus.src = "<?php echo Resource::GetImageUrl()?>/minus.gif";
 plus = new Image();
 plus.src = "<?php echo Resource::GetImageUrl()?>/plus.gif";
</script>

<form id="<?php echo $name?>" name="<?php echo $name?>">
<h2 ><?php echo $this->title?></h2>
<div  class="toplevel" style="width:180px; overflow:hidden; clear:both">
<table cellspacing="0" cellpadding="2" >
<tr>
<td  align="left">
   <table cellspacing="2" cellpadding="0">
   <tr>  
    <?php foreach ($this->actionPanel as $elem ): ?>
     <td><?php echo $elem['element']?></td>
   <?php endforeach; ?>
   <td><div id="<?php echo $name?>.load_disp" style="display:none"></div></td>
   </tr>
   </table>
</td>
</tr>
<tr>
<td colspan="9">
   <div id="<?php echo $name?>_data">
   <div id="<?php echo str_replace('.','_',$name)?>_tree" >
	<ul style="width:180px;">
        <?php 
        //echo "<pre>"; print_r($this->form['rootNodes']);echo "</pre>"; 
        foreach ($this->form['rootNodes'] as $node) {
            displayElement($name, $node);
        }
        ?>
	</ul>
    </div>

   </div>
</td>
</tr>
</table>
</div>
</form>

<script>

$j(function () {
	$j("#<?php echo str_replace('.','_',$name)?>_tree").tree({
	    ui : {
	        theme_name : "classic",
	        theme_path : false,
	        context : false
	    },
	    data : {
	        async : true,
	        async_data : function (NODE, TREE_OBJ) { return { id : $(NODE).attr("value") || 0 } },
	        method : "POST",
	        url : "<?php echo APP_URL;?>/bin/controller.php?F=RPCInvoke&P0=[<?php echo $name?>]&P1=[showChildrenNodes]"
	    },
	    rules : {
            clickable : [ "report" ],
            droppable : [ "tree-drop" ],
            multiple : true,
            drag_button : "left"
        },
        lang : {
			new_node: "New item",
			loading	: "Loading ..."
		},
        callback : {
            onselect : function(n,t) { 
                location.href='<?php echo APP_INDEX;?>/report/report_pre/'+n.value;
            }
        }
	});

    /* // select branch on the proper report id
    var tt = $j.tree_reference("<?php echo str_replace('.','_',$name)?>_tree");
    if ($('<?php echo $name.'_'.$folderId;?>')) {
        tt.select_branch($('<?php echo $name.'_'.$folderId;?>'));
    }*/
});  
</script>


<?php
// helper function here
    function displayElement($objName, $elem, $level=0)
    {
        $report_id = $_GET['fld:Id'];
        $nodeId = $elem->m_Id;
        $nodeName = $elem->m_Name;
        $text = $nodeName;
        $objId = $elem->m_ObjectId;
        $children = $elem->m_ChildNodes;
        if ($level < 2)  // only expand first n levels
            $class = 'open';
        else {
            if ($children && count($children)>0)
                $class = 'close';
            else
                $class = 'leaf';
        }
        
        if($elem->m_Type=='folder'){        
        	echo "<li id=\"".$objName."_"."$nodeId\" rel=\"".$elem->m_Type."\" value=\"$nodeId\" class=\"$class\"><a>$text</a>\n";
        }
        elseif($elem->m_Type=='report')
        {
            if ($elem->m_Id == $report_id) $clicked="clicked";
            else $clicked = '';
            $class = 'leaf';
        	echo "<li id=\"".$objName."_"."$nodeId\" rel=\"".$elem->m_Type."\" value=\"$nodeId\" class=\"$class\"><a style=\"width:100px;height:auto;display:inline-block;table-layout:fixed\"  class=\"leaf2 $clicked\" href=\"".$elem->m_Id."\">$text</a>\n";
        }
        if ($children && count($children)>0)
        {
            echo "<ul>\n";
            foreach ($children as $chld)
            {
                displayElement($objName, $chld, $level+1);
            }
            echo "</ul>\n";
        }
        echo "</li>\n";
    }
?>
<?php
ob_start();
require_once('app_init.php');

if (!APPBUILDER)
{
    echo "Sorry, AppBuilder/MetaEdit disable.";
    exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Openbiz Design Center</title>
	<link rel="stylesheet" href="<?php echo THEME_URL.'/'.DEFAULT_THEME_NAME;?>/css/general.css" type="text/css">
	<link rel="stylesheet" href="<?php echo THEME_URL.'/'.DEFAULT_THEME_NAME;?>/css/openbiz.css" type="text/css">
	<link rel="stylesheet" type="text/css" href="../js/jstree/tree_component.css" />
	<script type="text/javascript" src="../js/jstree/_lib.js"></script>
	<script type="text/javascript" src="../js/jstree/tree_component.js"></script>
<style type="text/css">
.panel{
	border:1px solid #999;
	padding-top:1em;
    padding-bottom:1em;
	background-color:white;
	-moz-border-radius:8px;
	-webkit-border-radius:8px;
	border-radius:8px;
}
</style>
</head>
<body style="margin:10px;background-color:#ffffff;">

<?php
$metaobj = $_GET['metaobj'];
$refobj = $_GET['refobj'];
$formDO = "";

class MetaXMLTree
{
    protected $m_MetaName;
    protected $m_XmlFile;
    protected $m_MetaType;
    public $m_SupportedMetaFile = true;
    
    function __construct($metaobj)
    {
        $this->m_MetaName = $metaobj;
        $this->m_XmlFile = MODULE_PATH."/".str_replace(".","/",$metaobj).".xml";
    }
    
    function displayXML2Tree()
    {
        if (file_exists($this->m_XmlFile)) {
            $rootElem = simplexml_load_file($this->m_XmlFile);
            $this->m_MetaType = $rootElem->getName();
            if ($this->m_MetaType != 'EasyForm' && $this->m_MetaType != 'EasyView' && $this->m_MetaType != 'BizDataObj')
            {
                //$this->m_SupportedMetaFile = false;
                //return;
            }
            $this->displayElement($rootElem, true);
            //print_r($rootElem);
        } else {
            exit('Failed to open '.$this->m_XmlFile);
        }
    }
    
    function displayElement($elem, $isRoot=false)
    {
        global $formDO;
        $elemName = $elem->getName();
        $attrs = $elem->attributes();
        if ($elemName == "EasyForm" && !empty($attrs['BizDataObj'])) {
            $formDO = $attrs['BizDataObj'];
        }
        $name = $attrs['Name'];
        if (!$name) $name = $attrs['name'];
        $text = ($name)&&($name!="") ? "$elemName: $name" : "$elemName";
        if ($isRoot)
            echo "<li id=\"$name\" class=\"open\" rel=\"$elemName\"><a href=\"#\">$text</a>\n";
        else
            echo "<li id=\"$name\" rel=\"$elemName\"><a href=\"#\">$text</a>\n";
        $children = $elem->children();
        if ($children && count($children)>0)
        {
            echo "<ul>\n";
            foreach ($children as $chld)
            {
                $this->displayElement($chld);
            }
            echo "</ul>\n";
        }
        echo "</li>\n";
    }
    
    function getTreeRules()
    {
        $rules = array();
        switch ($this->m_MetaType)
        {
            case "EasyForm" :
                $rules['deletable'] = '"Element", "EventHandler"';
                $rules['clickable'] = '"EasyForm", "Element", "EventHandler"';
                $rules['creatable'] = '"DataPanel", "SearchPanel", "ActionPanel", "NavPanel", "Element"';
                $rules['draggable'] = '"Element", "EventHandler"';
                $rules['dragrules'] = '"Element * Element", "EventHandler * EventHandler"';
                break;
            case "EasyView" :
                $rules['deletable'] = '"Reference"';
                $rules['clickable'] = '"EasyView", "Reference"';
                $rules['creatable'] = '"FormReferences"';
                $rules['draggable'] = '"Reference"';
                $rules['dragrules'] = '"Reference * Reference"';
                break;
            case "BizDataObj" :
                $rules['deletable'] = '"BizField", "Join", "Object"';
                $rules['clickable'] = '"BizDataObj", "BizField", "Join", "Object"';
                $rules['creatable'] = '"BizFieldList", "TableJoins", "ObjReferences"';
                $rules['draggable'] = '"BizField", "Join", "Object"';
                $rules['dragrules'] = '"BizField * BizField", "Join * Join", "Object * Object"';
                break;
            case "ETL" :
                $rules['deletable'] = '"Database", "Queue", "Task", "Transform"';
                $rules['clickable'] = '"Database", "Queue", "Task", "Transform"';
                $rules['creatable'] = '"DataSource", "Queue", "Task"';
                $rules['draggable'] = '"Task", "Transform"';
                $rules['dragrules'] = '"Task * Task", "Transform * Transform"';
                break;
        }
        return $rules;
    }
    
    function displayTreeScripts()
    {
        // compose tree rules according to the metadata type
        $rules = $this->getTreeRules();
    ?>
$(function () {
	$("#ob_element").tree({
	    ui : {theme_name : "classic"},
	    rules : {
            droppable : [ "tree-drop" ],
            multiple : true,
            deletable : [ <?php echo $rules['deletable']?> ],
            clickable : [ <?php echo $rules['clickable']?> ],
            renameable : "none",
            creatable : [ <?php echo $rules['creatable']?> ],
            draggable : [ <?php echo $rules['draggable']?> ],
            dragrules : [ <?php echo $rules['dragrules']?> ],
            drag_button : "left"
        },
        callback : {
            onselect : function(n,t) { 
                displayNodeAttrs(n, t, '<?php echo $this->m_MetaName; ?>'); 
            },
            beforecreate : function (n, r, h, t) {
				return setNewElement(n);
			},
			oncreate : function (n, r, h, t) {
			    // set pending new element, parent element and name attribute
			    pending_action['action'] = 'CREATE';
			    pending_action['elementPath'] = getElementPath(n, t); 
			    pending_action['attrName'] = n.id;
			    // TODO: get the parent element id
			    pending_action['prtAttrName'] = getParentElementAttrName(n, t);
			},
			beforedelete : function (n, t) {
				ok = confirm("Are you sure you want to delete '"+n.id+"'?");
				if (ok)
				{
				    pending_action['action'] = 'REMOVE';
    			    pending_action['elementPath'] = getElementPath(n, t);
    			    pending_action['attrName'] = n.id;
    			    pending_action['prtAttrName'] = getParentElementAttrName(n, t);
				}
				return ok;
			},
			onmove : function (n, r, type, t) {
			    // set pending new element, parent element and name attribute
			    pending_action['action'] = 'MOVE_'+type;
			    pending_action['elementPath'] = getElementPath(n, t);
			    pending_action['attrName'] = n.id+":"+r.id;
			    pending_action['prtAttrName'] = getParentElementAttrName(n, t);
			    t.select_branch(n);
			}
        }
	});
});  
    <?php
    }
}
?>

<div style="font-size:14px;font-weight:bold">Edit Openbiz Metadata: <?php echo $metaobj?></div>
<table border=0 cellspacing="5" width="98%">
<tr>
<td valign="top" class="panel">
<div id="ob_element" class="demo" style="width:220px;height:600px;overflow:auto;">
	<ul>
        <?php $metaTree = new MetaXMLTree($metaobj); $metaTree->displayXML2Tree(); ?>
	</ul>
    <div style="clear:both"></div>
    <?php if ($formDO != "") { ?>
    <div style="padding-left:5px;">
        &gt;&gt; <a href="metaedit.php?metaobj=<?php echo $formDO?>&refobj=<?php echo $metaobj?>">Edit <?php echo $formDO?></a>
    </div>
    <?php } ?>
    <?php if ($refobj) { ?>
    <div style="padding-left:5px;">
        &lt;&lt; <a href="metaedit.php?metaobj=<?php echo $refobj?>">Back to <?php echo $refobj?></a>
    </div>
    <?php } ?>
</div>
</td>
<td valign="top" class="panel">
<div id="attributes" style="width:760px;height:600px;">
<iframe frameborder=0 name="attributes_frame" id="attributes_frame" src="empty.php" width="100%" height="100%">
</iframe>
</div>
</td>
</tr>
</table>
<script type="text/javascript">

window.frames["attributes_frame"].location = "empty.php"; 

<?php 
if ($metaTree->m_SupportedMetaFile) 
    $metaTree->displayTreeScripts(); 
else
    echo "alert('$metaobj is not supported in Openbiz Metadata editor. Please use normal editor to edit it.');";
?>

var prt_chld_list = {
        'Element':'EventHandler', 
        'SearchPanel':'Element', 
        'DataPanel':'Element', 
        'ActionPanel':'Element', 
        'NavPanel':'Element',
        'FormReferences':'Reference',
        'BizFieldList':'BizField',
        'TableJoins':'Join',
        'ObjReferences':'Object',
        'DataSource':'Database',
        'Queue':'Task',
        'Task':'Tranform'
    };

var pending_action = {'action':'', 'elementPath':'', 'attrName':'', 'prtAttrName':''};

function getTreeObj()
{
    return $.tree_reference('ob_element');
}

function changeElementName(old_name, new_name)
{
    // reload xml 
    n = $("#"+old_name);
    n_a = $("#"+old_name+" a:first");
    n.attr('id', new_name);
    n_a.html(n.attr('rel')+': '+new_name);
    //n_a.html('Element: '+new_name);
    //alert('name changed from '+old_name+' to '+new_name);
}

function getParentElementAttrName(n, t)
{
    if (!t)
        t = getTreeObj();
    node = t.get_node(n);
    prtNode = t.parent(node);
    
    return prtNode.attr('id');
}

function getElementPath(n, t)
{
    if (!t)
        t = getTreeObj();
    node = t.get_node(n);
    path = node.attr('rel');
    if (node.attr('id')!='') path += '[@'+node.attr('id')+']';
    for (i=0; i<10; i++)
    {
        prtNode = t.parent(node); 
        if (!prtNode) 
            break;
        else {
            rel = prtNode.attr('rel');
            if (prtNode.attr('id')!='') rel += '[@'+prtNode.attr('id')+']';
            path = rel+"/"+path;
        }
        node = prtNode;
    }
    return path;
}

function displayNodeAttrs(n, t, metaName)
{
    var elemPath = getElementPath(n, t);
    
    var rel = n.getAttribute('rel');
    if (rel == null)
    {
        alert("Invalid 'rel' attribute of the selected element.");
        return;
    }
    formName = "tool.f_"+rel+"Edit";
    elemName = rel;
    attrNameValue = n.id;

    //url = "controller.php?view=tool.v_Attributes&form="+formName+"&metaName="+metaName+"&elemName="+elemName+"&attrName="+attrNameValue;
    url = "controller.php?view=tool.v_Attributes&form="+formName+"&metaName="+metaName+"&elemPath="+elemPath+"&attrName="+attrNameValue;
    if (pending_action['action'] != "")
        url = url + "&pending_action="+pending_action['action']+","+pending_action['elementPath']+","+pending_action['attrName']+","+pending_action['prtAttrName'];
    //alert(url);
    // clean pending action
    pending_action['action'] = "";
    //alert(url); return;
    window.frames["attributes_frame"].location = url; 
}

function setNewElement(n)
{
    var prt_rel = n.getAttribute('rel');
	rel = prt_chld_list[prt_rel];
	if (!rel)
	    return false;
    elemName = prompt("Please enter an unique "+rel+" name", "Enter "+rel+" name here"); 
	if (elemName == null)
	    return false;
	elemName = elemName.replace("/ /g","");
	if (elemName == "")
	    return false;
	
	n.id = elemName; // a unique number
	n.setAttribute('rel',rel);    // use parent type to decide the rel (child type)
	n.innerHTML = "<a href=\"#\">"+rel+": "+elemName+"</a>"; // New_rel
	return true;
}
</script>

</body>
</html>

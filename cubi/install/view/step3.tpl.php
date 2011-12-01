<div class="container">

    <div class="left left_style_b" >
        <img src="images/icon_step_03.jpg" />
        <h2>Application Configuration</h2>
    </div>

<div class="right right_style_b" style="padding-top:30px;">


<h4>Check Writable Directories:</h4>
<table class="form_table"  cellpadding="0" cellspacing="0" border="0" style="margin-bottom:20px;">
<tr>
	<th>Item</th>
	<th>Value</th>
	<th>Status</th>
</tr>
<?php
$status = getApplicationStatus();
$i=0;
$hasError = false;
foreach ($status as $s) {
    if(fmod($i,2)){
        $default_style="even";
    }else{
        $default_style="odd";
    }
    
    if (strpos($s['status'],'OK') === 0) {
        $flag_icon="flag_y.gif";        
    }else{
        $flag_icon="flag_n.gif";
		$hasError = true;
    }
     $i++;
?>
        <tr
            class="<?php echo $default_style;?>"
            onmouseover="if(this.className!='selected')this.className='hover'" 
            onmouseout="if(this.className!='selected')this.className='<?php echo $default_style;?>'" 
        >
            <td><?php echo $s['item'];?></td>
            <td><?php echo $s['value'];?></td>
            <td><img src="../themes/default/images/<?php echo $flag_icon;?>" /></td>
        </tr>
<?php
}
?>
</table>

<h4>Default Database in <?php echo APP_HOME.DIRECTORY_SEPARATOR;?>application.xml</h4>
<?php $db = getDefaultDB(); ?>
<table class="form_table"  cellpadding="0" cellspacing="0" border="0" style="margin-bottom:20px;">
<tr>
	<th>Name</th>
	<th>Driver</th>
	<th>Server</th>
	<th>Port</th>
	<th>DBName</th>
	<th>User</th>
	<th>Password</th>
</tr>
<tr
	class="even"
    onmouseover="if(this.className!='selected')this.className='hover'" 
    onmouseout="if(this.className!='selected')this.className='even'" 
>
    <td><?php echo $db['Name'];?></td>
    <td><?php echo $db['Driver'];?></td>
    <td><?php echo $db['Server'];?></td>
    <td><?php echo $db['Port'];?></td>
    <td><?php echo $db['DBName'];?></td>
    <td><?php echo $db['User'];?></td>
    <td><?php echo $db['Password'];?></td>
</tr>
</table>
<div style="display:none;">
<a href="javascript:load_modules();" class="button_m_highlight">Load Modules</a>
<a href="javascript:showContent('loadmodules_results','load modules');" class="button_m">Show results</a>
</div>
<div>
<div id="loadmodules_img"  style="display:none;color:red" ><img src="images/indicator.white.gif" style="display:none"/>Loading modules, it will takes 1-2 mintues, please wait...</div>
<span id="loadmodules_status"></span>
</div>
<div id="loadmodules_results" style="display:none;" onclick="showContent('loadmodules_results','load modules');">
</div>

<a href="index.php?step=2" class="button">< Back</a>
<?php 
if (!$hasError){
?>
    <a href="javascript:load_modules();" class="button_highlight">Next ></a>
<?php
}else{
?>
    <a href="index.php?step=3" class="button_m_highlight">Check Again</a>
<?php
}
?>

</div>
<div id="error_message" class="popup_dialog" onclick="this.style.display='none';"></div>
</div>
</div>

<script>
function load_modules()
{
    $('loadmodules_results').innerHTML='';
    $('loadmodules_status').innerHTML='';
    new Ajax.Request('index.php?action=load_modules', {
      onLoading: function() {
         Element.show('loadmodules_img');
      },
      onComplete: function() {
          //alert('komplete');
         Element.hide('loadmodules_img');
      },
      onSuccess: function(transport){
         var response = transport.responseText || "no response text";
         //alert('sukses'+response);
         $('loadmodules_results').innerHTML = response;
         if (response.indexOf('###')>=0) {
            $('loadmodules_status').innerHTML = response.substr(0,response.indexOf('###'));
            window.location = "index.php?step=4";
         }else{
        	 showContent('loadmodules_results','load modules');
         }
      },
      onFailure: function(){ alert('Something went wrong...') }
      //parameters: $('setupform').serialize()
   })
}

function showContent(div, title, w, h)
{
    var top;
    w = w ? w : 600; h = h ? h : 500;
    left = (screen.width) ? (screen.width-w)/2 : 0; top = (screen.height) ? (screen.height-h)/2 : 0;
    popup = window.open("","",'height='+h+',width='+w+',left='+left+',top='+top+',scrollbars=1,resizable=1,statu=0');
    text = $(div).innerHTML;
    body = "<body bgcolor=#D9D9D9><pre>"+text+"</pre></body>";
    popup.document.writeln("<head><title>"+title+"</title>"+body+"</head>");
}
</script>


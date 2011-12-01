<?php 
if(!$_REQUEST['dbtype']){
	loadDBConfig();
}
?>
<div class="container">

    <div class="left left_style_b">
        <img src="images/icon_step_02.jpg" />
        <h2>Database Configuration</h2>
    </div>

	<div class="right right_style_b" style="padding-top:15px;">
        <p>Please enter your database configuration information below.<br />
		 If you are unsure of what to fill in, we suggest that you use the default values.
        </p><p>
        The database information will be write to <strong>application.xml</strong>.
        
        </p>
<form id="setupform" name="setupform" method="post" action="install.php" >
<table class="input_row">
<tr>
	<td><label>Database Type</label></td>
	<td>
    <SELECT NAME="dbtype">
    <OPTION VALUE="Pdo_Mysql"<?php if($_REQUEST['dbtype']=="Pdo_Mysql") echo " selected='selected'";?>>MySQL
    <OPTION VALUE="Pdo_Pgsql"<?php if($_REQUEST['dbtype']=="Pdo_Pgsql") echo " selected='selected'";?>>PostgreSQL
    <OPTION VALUE="Pdo_OCi"<?php if($_REQUEST['dbtype']=="Pdo_OCi") echo " selected='selected'";?>>Oracle 
    <OPTION VALUE="Pdo_Mssql"<?php if($_REQUEST['dbtype']=="Pdo_Mssql") echo " selected='selected'";?>>SQL Server
    </SELECT>
    </td>
</tr>

<tr>
	<td>
    	<label>Database Host Name</label>
    </td>
	<td>
 
    <input class="input_text" onfocus="this.className='input_text_focus'" onblur="this.className='input_text'"
    	 type="text" name="dbHostName" value="<?php echo  isset($_REQUEST['dbHostName']) ? $_REQUEST['dbHostName'] : 'localhost'?>" tabindex="1" >
    </td>
</tr>
<tr>
	<td><label>Database Port</label></td>
	<td><input class="input_text" onfocus="this.className='input_text_focus'" onblur="this.className='input_text'" 
    		type="text" name="dbHostPort" value="<?php echo  isset($_REQUEST['dbHostPort']) ? $_REQUEST['dbHostPort'] : '3306'?>" tabindex="3"></td>
</tr>
<tr>
	<td><label>Database Name</label></td>
	<td><input class="input_text" onfocus="this.className='input_text_focus'" onblur="this.className='input_text'" 
    		type="text" name="dbName" value="<?php echo  isset($_REQUEST['dbName']) ? $_REQUEST['dbName'] : 'cubi'?>" tabindex="3"></td>
</tr>
<tr>
	<td ><label>Database Username</label></td>
	<td><input class="input_text" onfocus="this.className='input_text_focus'" onblur="this.className='input_text'"
    		 type="text" name="dbUserName" value="<?php echo  isset($_REQUEST['dbUserName']) ? $_REQUEST['dbUserName'] : 'root'?>" tabindex="4"> <span class="input_desc">&nbsp;</span></td>
</tr>
<tr>
	<td ><label>Database Password</label></td>
	<td><input class="input_text" onfocus="this.className='input_text_focus'" onblur="this.className='input_text'"
    		type="password" name="dbPassword" value="<?php echo  isset($_REQUEST['dbPassword']) ? $_REQUEST['dbPassword'] : ''?>" tabindex="5" > <span class="input_desc">&nbsp;</span></td>
</tr>
<!--<tr>
<td>
	<label>Load Modules</label>
</td>
<td>
	<input type="checkbox" checked="checked" name="load_db" id="load_db" tabindex="6" />
	<img id="filldb_img" src="images/indicator.white.gif" alt="Load DB indicator." style="display:none"/>
    <span id="fill_db_result"></span>
</td>
</tr>-->
<tr>
<td>
	<label>Create Database</label>
</td>
<td>
	<input  type="checkbox" <?php if($_REQUEST['create_db']!='N'){ echo "checked=\"checked\""; }?>  name="create_db" id="create_db" tabindex="6" />
	<img id="createdb_img" src="images/indicator.white.gif" alt="Create DB indicator." style="display:none"/>
    <span id="create_db_result" style="color:red"></span>
</td>	
</tr>

</table>

</form>

    <a href="index.php?step=1" class="button">&lt; Back</a>
    <a href="javascript:step2_next()" class="button_highlight">Next &gt;</a>
    
</div>

<div id="notice_message" class="popup_dialog" onclick="this.style.display='none';">
        <img id="createdb_img" src="images/indicator.white.gif" style="display:none"/>
        <span id="create_db_result"></span>
        <img id="filldb_img" src="images/indicator.white.gif" style="display:none"/>
        <span id="fill_db_result"></span>
    </div>
    <div id="error_message" class="popup_dialog" onclick="this.style.display='none';"></div>

</div>

<script>
function step2_next()
{
    if ($('create_db').checked) {
        create_db();
    }
    else {
		replace_db_cfg();
        //window.location = "index.php?step=3";
    }
    /*
    if ($('load_db').checked && !$('create_db').checked) {
        fill_db();
    }
    if (!$('load_db').checked && !$('create_db').checked)
        alert("Please select the above checkboxes to continue.");
    */
}

function replace_db_cfg()
{
    $('create_db_result').innerHTML='';
    new Ajax.Request('index.php?action=replace_db_cfg', {
      onLoading: function() {
         Element.show('createdb_img'); // or $('createdb_img').show();
      },
      onComplete: function() {
          
         Element.hide('createdb_img');
      },
      onSuccess: function(transport){
         var response = transport.responseText || "no response text";
         $('create_db_result').innerHTML=response;
         if (response.indexOf('SUCCESS')>=0) {
            /*if ($('load_db').checked)
                fill_db();*/
            window.location = "index.php?step=3";
         }
      },
      onFailure: function(){ alert('Something went wrong...') },
      parameters: $('setupform').serialize()
   })	
}

function create_db()
{
    $('create_db_result').innerHTML='';
    new Ajax.Request('index.php?action=create_db', {
      onLoading: function() {
         Element.show('createdb_img'); // or $('createdb_img').show();
      },
      onComplete: function() {
          
         Element.hide('createdb_img');
      },
      onSuccess: function(transport){
         var response = transport.responseText || "no response text";
         $('create_db_result').innerHTML=response;
         if (response.indexOf('SUCCESS')>=0) {
            /*if ($('load_db').checked)
                fill_db();*/
            window.location = "index.php?step=3";
         }
      },
      onFailure: function(){ alert('Something went wrong...') },
      parameters: $('setupform').serialize()
   })
}
/*
function fill_db()
{
    $('fill_db_result').innerHTML='';
    new Ajax.Request('index.php?action=fill_db', {
      onLoading: function() {
         Element.show('filldb_img');
      },
      onComplete: function() {
          //alert('komplete');
         Element.hide('filldb_img');
      },
      onSuccess: function(transport){
         var response = transport.responseText || "no response text";
         //alert('sukses'+response);
         $('fill_db_result').innerHTML = response;
         if (response.indexOf('SUCCESS')>=0) {
            window.location = "index.php?step=3";
         }
      },
      onFailure: function(){ alert('Something went wrong...') },
      parameters: $('setupform').serialize()
   })
}*/
</script>
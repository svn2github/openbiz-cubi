<form id="{$form.name}" name="{$form.name}">
<div style="padding-left:25px;padding-right:40px;">

	<div style="padding-left:10px;">
		{if $form.icon !='' }
		<div class="form_icon"><img  src="{$image_url}/{$form.icon}" border="0" /></div>
		{/if}
		<div style="float:left; width:600px;">
		<h2>
		{$form.title}
		</h2> 
		<p class="form_desc">{$form.description}</p>
		</div>
		<div class="underline" style="display:block;height:200px;">
			{foreach name=row item=item key=itemName from=$dataPanel}
				{if $item.elementset eq "Selector"}	
                    <table  id="{$itemName}_container" class="input_row" style="float:left">
					<tr>
						<td>
							<label style="text-align:left;width:150px; float:none;">{$item.label}</label>				
							<span class="label_text" style="width:200px;">{$item.element}</span>					
						</td>
					</tr>
					</table>
				{/if}
			{/foreach}					
		</div>

		<div class="underline" style="display:block">
			{foreach name=row item=item key=itemName from=$dataPanel}
				{if $item.elementset eq "Report"}	
                    <table  id="{$itemName}_container" class="input_row" >

					<tr>
						<td >	
							<label style="text-align:left; ">{$item.label}</label>
						</td>
						<td>				
							<span class="label_text" style="width:500px;">{$item.element}</span>					
						</td>
					</tr>
					</table>
				{/if}
			{/foreach}					
		</div>		
		
		<div style="height:10px;"></div>
		
		<p class="input_row">
			
			{foreach item=elem from=$actionPanel}
				{$elem.element}
			{/foreach}
		</p>
	{if $errors}
	    <div id='errorsDiv' class='innerError errorBox'>
	    {foreach item=errMsg from=$errors}
	        <div>{$errMsg}</div>
	    {/foreach}
	    {literal}<script>setTimeout("$('errorsDiv').fade( {from: 1, to: 0});",3000);</script>{/literal}
	    </div>
	{/if}
	
	{if $notices}
	    <div id='noticeDiv' class='noticeBox' >
	    {foreach item=noticeMsg from=$notices}
	        <div>{$noticeMsg}</div>
	    {/foreach}
	    </div>
	    {literal}<script>setTimeout("$('noticeDiv').fade( {from: 1, to: 0});",3000);</script>{/literal}
	{/if}			
	</div>
	
	<div style="height:5px;">
	<div id='{$form.name}.load_disp' style="display:none;">
	<img  src="{$image_url}/form_ajax_loader.gif"/>
	</div>
	</div>
	
</div>
<script>
{literal}
function CheckAll(){
	for(var i=0; i<fld_report_optlist.length; i++){
		$(fld_report_optlist[i]).checked=true;
		}
}

function UncheckAll(){
	for(var i=0; i<fld_report_optlist.length; i++){
		$(fld_report_optlist[i]).checked=false;
		}	
}
function CheckDefault(){
	UncheckAll();
	for(var i=0; i<fld_report_optlist_default.length; i++){
		$(fld_report_optlist_default[i]).checked=true;
		}	
}
{/literal}
</script>
</form>

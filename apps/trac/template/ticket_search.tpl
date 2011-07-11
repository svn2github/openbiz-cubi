<form id="{$form.name}" name="{$form.name}">
<div style="padding-left:25px; ">

	<div style="padding-left:0px;">
		<h2><a id="{$form.name}_content_toggler" href="#" class="shrink" onclick="toggleDisplay('{$form.name}_content');"></a>Search Ticket</h2>
		<div id="{$form.name}_content" style="display:block;padding-left:10px;">
		<div class="" style="height:160px;">			
			{foreach name=phone item=item key=itemName from=$dataPanel}
				{if $item.elementset eq "General"}			
					{if $smarty.foreach.phone.index is odd}
					<table  id="{$itemName}_container" class="input_row" style="float:left;">
					{else}
					<table  id="{$itemName}_container" class="input_row" style="float:left;">
					{/if}								
					<tr>
						<td >	
							<label style="text-align:left;width:80px; ">{$item.label}</label>
						</td>
						<td>				
							<span class="label_text" style="width:225px;">{$item.element}</span>					
						</td>
					</tr>
					</table>
				{/if}						
			{/foreach}			
		</div>
		
		<div style="display:block; padding:5px 5px 0px 0px; width:650px;">
			{foreach item=item key=itemName from=$dataPanel}
				{if $item.elementset eq "Content"}		
					<table  id="{$itemName}_container" class="input_row">								
					<tr>
						<td >	
							<label style="text-align:left; ">{$item.label}</label>
						</td>
						<td>				
							<span class="label_text" style="width:550px;">{$item.element}</span>					
						</td>
					</tr>
					</table>	
				{/if}						
			{/foreach}		
		</div>
		
		<div style="height:25px;">
			{$dataPanel.fld_owner_id.element}
			{foreach name=phone item=item key=itemName from=$dataPanel}
				{if $item.elementset eq "Contact" and $item.type != "Hidden"}
					<table  id="{$itemName}_container" class="input_row" style="float:left;">						
					<tr>
						<td>	
							<label style="text-align:left;width:80px; ">{$item.label}</label>
						</td>
						<td>				
							<span class="label_text" style="width:225px;">{$item.element}</span>					
						</td>
					</tr>
					</table>
				{/if}						
			{/foreach}			
		</div>

  		<div style="clear:both"></div>
  
		<div style="height:10px;"></div>
		<p class="input_row">
			
			{foreach item=elem from=$actionPanel}
				{$elem.element}
			{/foreach}
		</p>
		</div>
	</div>
	
	<div style="height:10px;">
	<div id='{$form.name}.load_disp' style="display:none;">
	<img  src="{$image_url}/form_ajax_loader.gif"/>
	</div>
	</div>
	
</div>
<hr style="width:700px; color:white; maring-left: 20px;margin-bottom:10px; "></hr>
</form>

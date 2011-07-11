<form id="{$form.name}" name="{$form.name}">
<div style="padding-left:25px; ">

	<div style="padding-left:10px;">
		<h2>Ticket #{$dataPanel.fld_Id.element}</h2>
		<div class="underline" style="display:block">
			{foreach item=item key=itemName from=$dataPanel}
				{if $item.elementset eq "Content"}
					{if $item.type eq 'CKEditor' or $item.type eq 'RichText' or $item.type eq 'Textarea'}
					<table  id="{$itemName}_container" class="input_row">
					<tr>
					<td style="width:100px;">	
						<label style="text-align:left;width:120px;">{$item.label}</label>
					</td>
					<td>
						{if $errors.$itemName}
						<span class="input_error_msg" style="width:240px;">{$errors.$itemName}</span>
						{elseif $item.description}
						<span class="input_desc" style="width:240px;">{$item.description}</span>			
						{/if}
					</td>
					</tr>
					<tr><td colspan="2" align="center" >
						<span class="label_text" style="width:700px">{$item.element}</span>
									
					</td></tr>
					</table>		
					{else}			
					<table  id="{$itemName}_container" class="input_row">								
					<tr>
						<td >	
							<label style="text-align:left; ">{$item.label}</label>
						</td>
						<td>				
							<span class="label_text" style="width:550px">{$item.element}</span>					
						</td>
					</tr>
					</table>
				{/if}	
				{/if}						
			{/foreach}		
		</div>
		
		<div class="underline" style="height:30px;">
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
		
		<div class="underline" style="height:160px;">			
			{foreach name=phone item=item key=itemName from=$dataPanel}
				{if $itemName != "fld_Id" and $item.elementset eq "General"}			
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

  		<div style="clear:both"></div>
  
		<div style="height:10px;"></div>
		<p class="input_row">
			
			{foreach item=elem from=$actionPanel}
				{$elem.element}
			{/foreach}
		</p>
	</div>
	
	<div style="height:15px;">
	<div id='{$form.name}.load_disp' style="display:none;">
	<img  src="{$image_url}/form_ajax_loader.gif"/>
	</div>
	</div>
	
</div>
</form>

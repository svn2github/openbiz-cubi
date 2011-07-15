<form id='{$form.name}' name='{$form.name}' style="width:350px;padding-left:15px">
<div style="padding-left:0px;padding-right:0px;">
	<div>
{include file="system_appbuilder_btn.tpl.html"}
	
	{if $form.icon !='' }
	<div><img  src="{$image_url}/{$form.icon}" border="0" /></div>
	{/if}
	<h3 title="{$form.description}">
	{$form.title}
	</h3>    
	</div>
{if $actionPanel or $searchPanel }	
	<div>	
				<div>
		{foreach item=elem from=$actionPanel}
		    	{$elem.element}
		{/foreach}
				</div>
				<div>
		{foreach item=elem from=$searchPanel}
			{if $elem.label} {$elem.label} {/if} {$elem.element}
		{/foreach}
				</div>
	</div>
{/if}	


<!-- table start -->
<table border="0" cellpadding="0" cellspacing="0" class="form_table" style="width:350px;" id="{$form.name}_data_table">
	<thead>		
     {foreach item=cell from=$dataPanel.elems}	
         <th onmouseover="this.className='hover'" 
			onmouseout="this.className=''"
			>{$cell.label}</th>	 
     {/foreach}
	</thead>

     {assign var=row_counter value=0}            
     {foreach item=row from=$dataPanel.data}
         {if $form.currentRecordId == $dataPanel.ids[$row_counter]}  
         {assign var=default_selected_id value=$dataPanel.ids[$row_counter]}       	
			<tr id="{$form.name}-{$dataPanel.ids[$row_counter]}" 
					class="selected"  normal="even" select="selected"
					onmouseover="if(this.className!='selected')this.className='hover'" 
					onmouseout="if(this.className!='selected')this.className='even'" 
					onclick="Openbiz.CallFunction('{$form.name}.SelectRecord({$dataPanel.ids[$row_counter]})');">
         {elseif $row_counter == 0 and $form.currentRecordId == ""}
         {assign var=default_selected_id value=$dataPanel.ids[$row_counter]}    
			<tr id="{$form.name}-{$dataPanel.ids[$row_counter]}" 
					class="selected"  normal="even" select="selected"
					onmouseover="if(this.className!='selected')this.className='hover'" 
					onmouseout="if(this.className!='selected')this.className='even'" 
					onclick="Openbiz.CallFunction('{$form.name}.SelectRecord({$dataPanel.ids[$row_counter]})');">
          {elseif $row_counter is odd}
		   <tr id="{$form.name}-{$dataPanel.ids[$row_counter]}" 
		   		class="odd"  normal="odd" select="selected"
					onmouseover="if(this.className!='selected')this.className='hover'" 
					onmouseout="if(this.className!='selected')this.className='odd'"  
					onclick="Openbiz.CallFunction('{$form.name}.SelectRecord({$dataPanel.ids[$row_counter]})');">
         {else}
			<tr id="{$form.name}-{$dataPanel.ids[$row_counter]}" 
					class="even"  normal="even" select="selected"
					onmouseover="if(this.className!='selected')this.className='hover'" 
					onmouseout="if(this.className!='selected')this.className='even'" 
					onclick="Openbiz.CallFunction('{$form.name}.SelectRecord({$dataPanel.ids[$row_counter]})');">
         {/if}
         
         {assign var=col_counter value=0}    
         {foreach key=name item=cell from=$row}
         	{if $col_counter eq 0}
         		{assign var=col_class value=' class="row_header" '}    
         	{else}
         		{assign var=col_class value=' '}
         	{/if}
            {if $cell != ''}            	
              <td {$col_class} >{$cell}</td>
            {else}
              <td {$col_class} >&nbsp;</td>
            {/if}
            {assign var=col_counter value=$col_counter+1}
         {/foreach}
                  
		{assign var=row_counter value=$row_counter+1}
		</tr>
     {/foreach}
  
							
</table>

<!-- status switch  -->
<script>
{if $form.status eq 'Enabled'}
{elseif $form.status eq 'Disabled'}
$('{$form.name}_data_table').fade({literal}{ duration: 0.5, from: 1, to: 0.35 }{/literal});
{/if}
</script>
<span id='{$form.name}_selected_id' style="display:none">{$default_selected_id}</span>
<!-- table end -->	

	<div>
		<div class="ajax_indicator" style="width:100px">
			<div id='{$form.name}.load_disp' style="display:none" >
				<img src="{$image_url}/form_ajax_loader.gif"/>
			</div>
		</div>
		<div class="navi_panel" style="width:150px;">
{if $navPanel}
   {foreach item=elem from=$navPanel}
   		{if $elem.label} <label style="width:68px;">{$elem.label}</label>{/if}
    	{$elem.element}
   {/foreach}
{/if}			
		
		</div>		
	</div>
	<div class="v_spacer"></div>
</div>
</form>
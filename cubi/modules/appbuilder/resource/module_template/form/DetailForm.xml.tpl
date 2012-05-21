<?xml version="1.0" encoding="UTF-8"?>
<EasyForm Name="{$form_name}" 
			Class="{$form_class}" 
			FormType="Detail" 
			jsClass="Openbiz.Form" 
			Icon="{$form_icon}"
			Title="{$form_title}" 
			Description="{$form_description}" 
			BizDataObj="{$form_do}" 
			TemplateEngine="Smarty" 
			TemplateFile="{$form_template}" 
			MessageFile="{$message_file}" 
			Access="{$acl.access}">
    <DataPanel>
{if $features.data_type eq 1}	    
		<Element Name="fld_form_title"  
					Class="LabelText"   
					FieldName="{$search_field.Field}" 
					Label="" 
					Width="500" 
					style="font-size:24px;color:#333333;line-height:24px;" 
					AllowURLParam="N" />
		<Element Name="fld_color" 
					Class="Hidden" 
					Hidden="Y" 
					FieldName="type_color" 
					Label="Type"  
					Sortable="Y" 
					AllowURLParam="N" 
					Translatable="N" 
					OnEventLog="N" />
		<Element Name="fld_form_description"  
					BackgroundColor="{literal}{@:Elem[fld_color].Value}{/literal}" 
					Width="648" 
					Class="LabelText" 
					FieldName="type_name" 
					Label="" 
					KeepCookie="Y" 
					SelectFrom="{$form_type_do}[name:Id:color]" 
					AllowURLParam="N" />					
{/if}

{foreach from=$fields item=fld}
{if $fld.Field != 'Id' && 
	$fld.Field != 'id' && 
	$fld.Field != 'type_id' && 
	$fld.Field != 'create_by' &&	
	$fld.Field != 'create_time' && 
	$fld.Field != 'update_by' && 
	$fld.Field != 'update_time' && 
	$fld.Field != 'other_perm' && 
	$fld.Field != 'group_perm' &&
	$fld.Field != 'group_id' &&
	$fld.Field != 'owner_id' &&
	$fld.Field != 'sortorder' &&
	$fld.Field != 'sort_order' &&
	$fld.Field != 'type_name' &&
	$fld.Field != 'type_color'  
	}
{if $features.extend eq 1 && $fld.Field eq $search_field.Field}
{else}
       	<Element Name="fld_{$fld.Field}" 
       				ElementSet="General" 
       				Class="LabelText" 
       				FieldName="{$fld.Field}" 
       				Label="{$fld.FieldLabel}" 
       				AllowURLParam="{if $fld.Field eq 'Id'}Y{else}N{/if}"/>
{/if}
{elseif $fld.Field == 'id' }
       	<Element Name="fld_Id" 
       				Class="LabelText" 
       				ElementSet="General"
       				Hidden="Y" 
       				FieldName="Id" 
       				Label="{$fld.FieldLabel}"  
       				AllowURLParam="Y"/>     
{elseif $fld.Field == 'type_id' }
       	<Element Name="fld_{$fld.Field}" 
       				Class="LabelText" 
       				ElementSet="General"
       				Hidden="Y" 
       				FieldName="{$fld.Field}" 
       				Label="{$fld.FieldLabel}"  
       				AllowURLParam="N"/>         
{if $features.extend eq 1}	
		<Element Name="fld_extend_fields"   
					ElementSet="Extend Fields" 
					Class="FormElement" 
					FormReference="extend.widget.ExtendDataDetailForm" 
					FieldName="extend" 
					Label="" 
					AllowURLParam="N" />
{/if}       				  				      				
{elseif $fld.Field == 'create_by' || 
		$fld.Field == 'update_by'}
       	<Element Name="fld_{$fld.Field}" 
       				Class="LabelText" 
       				ElementSet="Miscellaneous" 
       				FieldName="{$fld.Field}" 
       				Label="{$fld.FieldLabel}" 
       				Text="{literal}{{/literal}BizSystem::GetProfileName(@:Elem[fld_{$fld.Field}].Value){literal}}{/literal}" 
       				AllowURLParam="N"
       				{if $features.extend eq 1}TabSet="Misc"{/if}/>    
       				   	
{elseif $fld.Field == 'create_time' || 
		$fld.Field == 'update_time' ||
		$fld.Field == 'sortorder' ||
		$fld.Field == 'sort_order'  
		}
       	<Element Name="fld_{$fld.Field}" 
       				Class="LabelText" 
       				ElementSet="Miscellaneous" 
       				FieldName="{$fld.Field}" 
       				Label="{$fld.FieldLabel}"  
       				AllowURLParam="N"
       				{if $features.extend eq 1}TabSet="Misc"{/if} />       	

					
{/if}
{/foreach}
    </DataPanel>
    <ActionPanel>   
    	{literal}  
    	 <Element Name="btn_share" 
    	 			Hidden="{@:m_CanUpdateRecord=='1'?'N':'Y'}" 
    	 			Class="Button"   
    	 			Text="Share" 
    	 			CssClass="button_gray_share" 
    	 			Description="Share">
			<EventHandler Name="btn_update_onclick" 
							Event="onclick" 
							Function="LoadDialog(common.form.DataSharingForm,{@:Elem[fld_Id].Value})" />
        </Element>  
        <Element Name="btn_spacer_for_share" 
	        		Hidden="{@:m_CanUpdateRecord=='1'?'N':'Y'}" 
	        		Class="Spacer" 
	        		Width="10" />
    	{/literal}  
        <Element Name="btn_new" 
        			Class="Button" 
        			Text="Add" 
        			CssClass="button_gray_add" 
        			Description="New record (Insert)">
			<EventHandler Name="btn_new_onclick" 
							Event="onclick" 
							Function="SwitchForm({$comp}.{$new_form})"  
							ShortcutKey="Insert" 
							ContextMenu="New" />
        </Element>          
        <Element Name="btn_edit" 
        			Class="Button" 
        			Text="Edit" 
        			CssClass="button_gray_m" 
        			Description="Edit record (Ctrl+E)">
			<EventHandler Name="btn_new_onclick" 
							Event="onclick" 
							Function="SwitchForm({$comp}.{$edit_form},{literal}{@:Elem[fld_Id].Value}{/literal})"  
							ShortcutKey="Ctrl+E" 
							ContextMenu="Edit" />
        </Element>
		<Element Name="btn_copy" 
					Class="Button" 
					Text="Copy" 
					CssClass="button_gray_m" 
					Description="Copy record (Ctrl+C)">
            <EventHandler Name="onclick" 
            				Event="onclick" 
            				EventLogMsg="" 
            				Function="CopyRecord({literal}{@:Elem[fld_Id].Value}{/literal})" 
            				RedirectPage="form={$comp}.{$copy_form}&amp;fld:Id={literal}{@:Elem[fld_Id].Value}{/literal}" 
            				ShortcutKey="Ctrl+C" 
            				ContextMenu="Copy"/>
        </Element> 
        <Element Name="btn_delete" 
        			Class="Button" 
        			Text="Delete" 
        			CssClass="button_gray_m" 
        			Description="Delete record (Delete)">
            <EventHandler Name="del_onclick" 
            				Event="onclick" 
            				EventLogMsg="" 
            				Function="DeleteRecord({literal}{@:Elem[fld_Id].Value}{/literal})"  
            				RedirectPage="form={$comp}.{$list_form}" 
            				ShortcutKey="Ctrl+Delete" 
            				ContextMenu="Delete" />
        </Element>
        <Element Name="btn_cancel" 
        			Class="LabelBack" 
        			Text="Back" 
        			CssClass="button_gray_m"
        			Link="{$list_view_url}" />        
    </ActionPanel> 
    <NavPanel>
    </NavPanel> 
    <SearchPanel>
    </SearchPanel>
</EasyForm>
<?xml version="1.0" encoding="UTF-8"?>
<EasyForm Name="{$form_name}" 
			Class="{$form_class}" 
			FormType="Edit" 
			jsClass="Openbiz.Form" 
			Icon="{$form_icon}"
			Title="{$form_title}" 
			Description="Here you can edit extend fields for selected type of data" 
			BizDataObj="{$form_do}" 
			TemplateEngine="Smarty" 
			TemplateFile="{$form_template}" 
			MessageFile="{$message_file}" 
			Access="{$acl.create}">
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
   				  		
					
{/if}
{/foreach}
		<Element Name="fld_type_id" 
				ElementSet="Data Type"
				Class="common.lib.TypeSelector" 
				FieldName="type_id" 
				Label="Type" 
				KeepCookie="Y" 
				SelectFrom="{$form_type_do}[name:Id:color]" 
				AllowURLParam="N" >
   			<EventHandler Name="fld_type_id_onchange" 
   						Event="onchange" 
   						Function="UpdateForm()" />
		</Element>
		
		<Element Name="fld_extend_fields"   
				ElementSet="Extend Fileds"  
				Class="FormElement" 
				FormReference="extend.widget.ExtendDataEditForm" 
				FieldName="extend" 
				Label="" 
				AllowURLParam="N" />

	</DataPanel>
    <ActionPanel>  
        <Element Name="btn_finish" 
        		Class="Button" 
        		Text="Finish" 
        		CssClass="button_gray_w">
            <EventHandler Name="finish_onclick" 
            			EventLogMsg="" 
            			Event="onclick" 
            			Function="UpdateRecord()" 
            			RedirectPage="{literal}{APP_INDEX}{/literal}/{$detail_view_url}/{literal}{{/literal}@{$form_do}:Field[Id].Value{literal}}{/literal}" 
            			ContextMenu="Finish"   />
        </Element>
        <Element Name="btn_cancel" 
        		Class="Button" 
        		Text="Cancel" 
        		CssClass="button_gray_m">
            <EventHandler Name="btn_cancel_onclick" 
            			Event="onclick" 
            			Function="SwitchForm()"  
            			ShortcutKey="Escape" 
            			ContextMenu="Cancel" />
        </Element>        
    </ActionPanel> 
    <NavPanel>
    </NavPanel> 
    <SearchPanel>
    </SearchPanel>
</EasyForm>
<?xml version="1.0" encoding="UTF-8"?>
<EasyForm Name="{$form_name}" 
			Class="{$form_class}"			  
			FormType="Edit" 
			jsClass="Openbiz.Form" 
			Icon="{$form_icon}"
			Title="{$form_title}" 
			Description="Edit selected data type item."
			BizDataObj="{$form_do}" 
			PageSize="10" 
			DefaultForm="Y" 
			TemplateEngine="Smarty" 
			TemplateFile="{$form_template}" 
			EventName="{$event_name}" 
			MessageFile="{$message_file}" 
			Access="{$acl.access}">			
    <DataPanel>
{literal}    
		<Element Name="fld_Id" 
				Class="Hidden" 
				ElementSet="General" 
				FieldName="Id" 
				Label="Id" 
				AllowURLParam="Y" 
				Translatable="N" 
				OnEventLog="N" 
				CssClass="input" 
				CssErrorClass="input_error"/>
		<Element Name="fld_name" 
				ElementSet="General" 
				Class="InputText" 
				FieldName="name" 
				Label="Name"   />	
        <Element Name="fld_description" 
        		ElementSet="General" 
        		Class="Textarea" 
        		FieldName="description" 
        		Label="Description" />	
        <Element Name="fld_color_code" 
        		ElementSet="General" 
        		Class="ColorPicker" 
        		Mode="" 
        		FieldName="color" 
        		Label="Color Code"  
        		AllowURLParam="N" />
        <Element Name="fld_published" 
        		ElementSet="Miscellaneous" 
        		Class="Listbox" 
        		KeepCookie="Y" 
        		SelectFrom="common.lov.CommLOV(Published)"  
        		DefaultValue="1" 
        		FieldName="group_perm" 
        		Label="Group Share"  />
        <Element Name="fld_published_other" 
        		ElementSet="Miscellaneous" 
        		Class="Listbox" 
        		KeepCookie="Y" 
        		SelectFrom="common.lov.CommLOV(Published)"  
        		DefaultValue="0" 
        		FieldName="other_perm" 
        		Label="Other Group"  />	
        <Element Name="fld_sortorder" 
        		ElementSet="Miscellaneous" 
        		Class="Listbox" 
        		SelectFrom="common.lov.CommLOV(Order)" 
        		DefaultValue="50" 
        		FieldName="sortorder" 
        		Label="Sorting"  />
{/literal}        		
    </DataPanel>
    <ActionPanel>
        <Element Name="btn_save" 
        			Class="Button" 
        			Text="Save" 
        			CssClass="button_gray_m">
            <EventHandler Name="save_onclick" 
            			EventLogMsg="" 
            			Event="onclick" 
            			Function="UpdateRecord()" 
            			RedirectPage="form={$detail_form_full_name}&amp;fld:Id={literal}{{/literal}@{$form_do}:Field[Id].Value{literal}}{/literal}"  
            			ShortcutKey="Ctrl+Enter" 
            			ContextMenu="Save" />
        </Element>
        <Element Name="btn_cancel" 
        			Class="Button" 
        			Text="Cancel" 
        			CssClass="button_gray_m">
            <EventHandler Name="cancel_onclick" 
            			Event="onclick" 
            			Function="SwitchForm()"  
            			ShortcutKey="Escape" 
            			ContextMenu="Cancel"/>
        </Element> 
    </ActionPanel> 
    <NavPanel>
    </NavPanel> 
    <SearchPanel>
    </SearchPanel>
</EasyForm>
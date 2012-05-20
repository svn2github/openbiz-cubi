<?xml version="1.0" encoding="UTF-8"?>
<EasyForm Name="{$form_name}" 
		Class="{$form_class}"			  
		FormType="Edit" 
		jsClass="Openbiz.Form" 
		Icon="{$form_icon}"
		Title="{$form_title}" 
		Description="Your can setup custom fields for this type of data."
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
					ElementSet="General" 
					Hidden="Y" 
					Class="LabelText" 
					FieldName="Id" 
					Label="Id" 
					AllowURLParam="Y"/>
			<Element Name="fld_form_title"  
					Class="LabelText" 
					FieldName="name" 
					Label="" 
					Width="500" 
					style="font-size:24px;color:#333333;line-height:24px;" />	
			<Element Name="fld_color" 
					Class="Hidden" 
					Hidden="Y" 
					FieldName="color" 
					Label="Type"  
					Sortable="Y" 
					AllowURLParam="N" 
					Translatable="N" 
					OnEventLog="N" />
			<Element Name="fld_form_description"  
					BackgroundColor="{@:Elem[fld_color].Value}" 
					Width="648" 
					Class="LabelText" 
					FieldName="description" 
					Label="" 
					KeepCookie="Y" 
					AllowURLParam="N" />
			
			<Element Name="fld_name" 
					ElementSet="General" 
					Class="LabelText" 
					FieldName="name" 
					Label="Name"  
					Sortable="Y" 
					AllowURLParam="N" 
					Translatable="N" 
					OnEventLog="N" />	
     		<Element Name="fld_description" 
     				ElementSet="General" 
     				Class="LabelText" 
     				FieldName="description" 
     				Label="Description"  
     				Sortable="Y" 
     				AllowURLParam="N" 
     				Translatable="N" 
     				OnEventLog="N" />
    		
    		<Element Name="fld_color_code" 
    				ElementSet="General" 
    				Class="ColorPicker" 
    				Mode="viewOnly" 
    				FieldName="color" 
    				Label="Color Code" 
    				AllowURLParam="N" />
    				
			<Element Name="fld_extend_setting" 
					Access="extend.access"  
					ElementSet="Extend Fields" 
					Class="FormElement" 
					AccessSelectFrom="extend.lov.ExtendPermLOV(ExtendAccess)" 
					FormReference="extend.widget.ExtendSettingListEditForm" 
					FieldName="" 
					Label="" 
					AllowURLParam="N" />     	
{/literal}  						
	</DataPanel>
    <ActionPanel> 
		<Element Name="btn_save" 
				Class="Button" 
				Text="Save" 
				CssClass="button_gray_m">
            <EventHandler Name="save_onclick" 
            			Event="onclick" 
            			EventLogMsg=""  
            			Function="UpdateRecord()" 
            			RedirectPage="form={$detail_form_full_name}&amp;fld:Id={literal}{{/literal}@{$form_do}:Field[Id].Value{literal}}{/literal}" 
            			ShortcutKey="Ctrl+Enter" 
            			ContextMenu="Save" />
        </Element>
        <Element Name="btn_cancel" 
        		Class="Button" 
        		Text="Cancel" 
        		CssClass="button_gray_m">
            <EventHandler Name="btn_cancel_onclick" 
            			Event="onclick" 
            			Function="SwitchForm({$list_form_full_name})"  
            			ShortcutKey="Escape" 
            			ContextMenu="Cancel" />
        </Element>     
    </ActionPanel> 
    <NavPanel>
    </NavPanel> 
    <SearchPanel>
    </SearchPanel>
</EasyForm>
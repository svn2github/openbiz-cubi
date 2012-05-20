<?xml version="1.0" encoding="UTF-8"?>
<EasyForm Name="{$form_name}" 
			Class="{$form_class}"			  
			FormType="Detail" 
			jsClass="Openbiz.Form" 
			Icon="{$form_icon}"
			Title="{$form_title}" 
			Description="Please fill in below field to create a new data type."
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
        	<Element Name="fld_published" 
        			ElementSet="General" 
        			Class="LabelList" 
        			SelectFrom="common.lov.CommLOV(Published)" 
        			FieldName="group_perm" 
        			Label="Group Share"  
        			Sortable="Y" 
        			AllowURLParam="N" 
        			Translatable="N"
        			OnEventLog="N" />
        	<Element Name="fld_published_other" 
        			ElementSet="General" 
        			Class="LabelList" 
        			SelectFrom="common.lov.CommLOV(Published)" 
        			FieldName="other_perm" 
        			Label="Other Group"  
        			Sortable="Y" 
        			AllowURLParam="N" 
        			Translatable="N" 
        			OnEventLog="N" />	
        	<Element Name="fld_sortorder" 
        			ElementSet="General"  
        			Class="LabelText" 
        			SelectFrom="common.lov.CommLOV(Order)"  
        			FieldName="sortorder" 
        			Label="Ordering"  
        			Sortable="Y" 
        			AllowURLParam="N" 
        			Translatable="N" 
        			OnEventLog="N" />
		    <Element Name="fld_create_by" 
		    		ElementSet="Miscellaneous" 
		    		Class="LabelText" 
		    		FieldName="create_by" 
		    		Label="Create By" 
		    		Text="{BizSystem::GetProfileName(@:Elem[fld_create_by].Value)}"  
		    		Link="{APP_INDEX}/collab/contact_detail/{BizSystem::GetProfileId(@:Elem[fld_create_by].Value)}" 
		    		AllowURLParam="N"/>
		    <Element Name="fld_create_time" 
		    		ElementSet="Miscellaneous" 
		    		Class="LabelText" 
		    		FieldName="create_time" 
		    		Label="Create Time" 
		    		AllowURLParam="N"/>
		    <Element Name="fld_update_by" 
		    		ElementSet="Miscellaneous" 
		    		Class="LabelText" 
		    		FieldName="update_by" 
		    		Label="Update By"  
		    		Text="{BizSystem::GetProfileName(@:Elem[fld_update_by].Value)}"  
		    		Link="{APP_INDEX}/collab/contact_detail/{BizSystem::GetProfileId(@:Elem[fld_update_by].Value)}" 
		    		AllowURLParam="N"/>
		    <Element Name="fld_update_time" 
		    		ElementSet="Miscellaneous" 
		    		Class="LabelText" 
		    		FieldName="update_time" 
		    		Label="Update Time" 
		    		AllowURLParam="N"/>
{/literal}		    		
	</DataPanel>
    <ActionPanel>       
        <Element Name="btn_new" 
        		Class="Button" 
        		Text="Add  " 
        		CssClass="button_gray_add" 
        		Description="New record (Insert)">
			<EventHandler Name="btn_new_onclick" 
						Event="onclick" 
						Function="SwitchForm({$new_form_full_name})"  
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
						Function="SwitchForm({$edit_form_full_name},{literal}{@:Elem[fld_Id].Value}{/literal})"  
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
            			RedirectPage="form={$copy_form_full_name}&amp;{literal}fld:Id={@:Elem[fld_Id].Value}{/literal}" 
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
            			RedirectPage="form={$list_form_full_name}" 
            			ShortcutKey="Ctrl+Delete" 
            			ContextMenu="Delete" />
        </Element>
        <Element Name="btn_cancel" 
        		Class="Button" 
        		Text="Back" 
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
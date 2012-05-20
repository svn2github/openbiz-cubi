<?xml version="1.0" encoding="UTF-8"?>
<EasyForm Name="BookmarkTypeEditForm" 
		Class="BookmarkTypeForm" 
		Icon="{RESOURCE_URL}/collab/bookmark/images/icon_bookmark_type.png"  
		FormType="Edit" 
		jsClass="jbForm" 
		Title="Edit Bookmark Type" 
		Description="Edit selected bookmark type item." 
		BizDataObj="collab.bookmark.do.BookmarkTypeDO" 
		DefaultForm="Y" 
		TemplateEngine="Smarty" 
		TemplateFile="detail.tpl" 
		EventName="BOOKMARK_TYPE"
		MessageFile="BookmarkType.msg" 
		Access="collab_bookmark.access">
    <DataPanel>
		<Element Name="fld_Id" 
				Class="Hidden" 
				FieldName="Id" 
				Label="Id" 
				AllowURLParam="Y" 
				Translatable="N" 
				OnEventLog="N" 
				CssClass="input" 
				CssErrorClass="input_error"/>
		<Element Name="fld_name" 
				Class="InputText" 
				FieldName="name" 
				Label="Name"   />	
        <Element Name="fld_description" 
        		Class="Textarea" 
        		FieldName="description" 
        		Label="Description" />	
        <Element Name="fld_color_code" 
        		Class="ColorPicker" 
        		Mode="" 
        		FieldName="color" 
        		Label="Color Code"  
        		AllowURLParam="N" />
        <Element Name="fld_published" 
        		Class="Listbox" 
        		KeepCookie="Y" 
        		SelectFrom="common.lov.CommLOV(Published)"  
        		DefaultValue="1" 
        		FieldName="group_perm" 
        		Label="Group Share"  />
        <Element Name="fld_published_other" 
        		Class="Listbox" 
        		KeepCookie="Y" 
        		SelectFrom="common.lov.CommLOV(Published)"  
        		DefaultValue="0" 
        		FieldName="other_perm" 
        		Label="Other Group"  />	
        <Element Name="fld_sortorder" 
        		Class="Listbox" 
        		SelectFrom="common.lov.CommLOV(Order)" 
        		DefaultValue="50" 
        		FieldName="sortorder" 
        		Label="Sorting"  />
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
            			RedirectPage="{literal}{APP_INDEX}{/literal}/{$detail_view_url}/{literal}{{/literal}@{$form_do}:Field[Id].Value{literal}}{/literal}"  
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
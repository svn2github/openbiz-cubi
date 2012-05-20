<?xml version="1.0" encoding="UTF-8"?>
<EasyForm Name="{$form_name}" 
			Class="{$form_class}"			  
			FormType="List" 
			jsClass="Openbiz.TableForm" 
			Icon="{$form_icon}"
			Title="{$form_title}" 
			Description="You can mamange your data items by types.  All user defined type are listed below."
			BizDataObj="{$form_do}" 
			PageSize="10" 
			DefaultForm="Y" 
			TemplateEngine="Smarty" 
			TemplateFile="{$form_template}" 
			EventName="{$event_name}" 
			MessageFile="{$message_file}" 
			Access="{$acl.access}">			
   <DataPanel>
        <Element Name="row_selections" 
        		Class="RowCheckbox"  
        		Label="" 
        		FieldName="Id" />
        <Element Name="fld_share" 
        		Class="ColumnShare" 
				MyPrivateImg="{$share_icons.icon_type_private}"
				MySharedImg="{$share_icons.icon_type_shared}"  
				GroupSharedImg="{$share_icons.icon_type_shared_group}"
				OtherSharedImg="{$share_icons.icon_type_shared_other}"				
				FieldName="create_by" 
				Label="Share"  
				Sortable="Y" 
				AllowURLParam="N" 
				Translatable="N" 
				OnEventLog="N" 
				Link="javascript:;">
			<EventHandler Name="fld_share_onclick" 
							Event="onclick" 
							Function="LoadDialog(common.form.DataSharingForm,{literal}{@:Elem[fld_Id].Value}{/literal})"/>		
		</Element>
        <Element Name="fld_Id" 
        		Class="Hidden" 
        		Hidden="Y" 
        		FieldName="Id" 
        		Label="ID" 
        		Sortable="Y" 
        		AllowURLParam="N" />
        <Element Name="fld_name" 
        		Class="ColumnText" 
        		FieldName="name" 
        		Label="Name"  
        		Sortable="Y" 
        		AllowURLParam="N" 
        		Translatable="N" 
        		OnEventLog="N" 
        		Link="javascript:">         
         	<EventHandler Name="fld_Id_onclick" 
         				Event="onclick" 
         				Function="SwitchForm({$detail_form_full_name},{literal}{@:Elem[fld_Id].Value}{/literal})"   />
        </Element>	
        <Element Name="fld_description"  
        		MaxLength="30"  
        		Class="ColumnText" 
        		FieldName="description" 
        		Label="Description"  
        		Sortable="Y" 
        		AllowURLParam="N" 
        		Translatable="N" 
        		OnEventLog="N" />	
        <Element Name="fld_color_code" 
        		Class="ColorPicker" 
        		Mode="ViewOnly" 
        		FieldName="color" 
        		Label="Color Code"  
        		Sortable="Y">
        </Element>
        <Element Name="fld_status" 
        		Class="ColumnBool" 
        		FieldName="group_perm" 
        		Label="Group Share"  
        		Sortable="Y" 
        		AllowURLParam="N" 
        		Translatable="N"
        		OnEventLog="N" 
        		Link="javascript:;">
			<EventHandler Name="fld_status_onclick" 
							Event="onclick" 
							Function="UpdateFieldValueXor({literal}{@:Elem[fld_Id].Value}{/literal},fld_status,{literal}{@:Elem[fld_status].Value}{/literal})"/>		
		</Element>	
        <Element Name="fld_sorting" 
        		Class="ColumnSorting" 
        		FieldName="sortorder" 
        		Label="Sorting"  
        		Sortable="Y" 
        		AllowURLParam="N" 
        		Translatable="N" 
        		OnEventLog="N" >
        	<EventHandler Name="fld_sortorder_up" 
        					Event="onclick" 
        					EventLogMsg="" 
        					Function="UpdateFieldValue({literal}{@:Elem[fld_Id].Value}{/literal},fld_sorting,{literal}{{/literal}@:Elem[fld_sorting].Value-5{literal}}{/literal})" />
			<EventHandler Name="fld_sortorder_down" 
        					Event="onclick" 
        					EventLogMsg="" 
        					Function="UpdateFieldValue({literal}{@:Elem[fld_Id].Value}{/literal},fld_sorting,{literal}{{/literal}@:Elem[fld_sorting].Value+5{literal}}{/literal})" />
        </Element>	
    </DataPanel>
    <ActionPanel>
        <Element Name="lnk_new" 
        		Class="Button" 
        		Text="Add" 
        		CssClass="button_gray_add" 
        		Description="New record (Insert)" >
            <EventHandler Name="lnk_new_onclick" 
            			Event="onclick" 
            			EventLogMsg="" 
            			Function="SwitchForm({$new_form_full_name})"  
            			ShortcutKey="Insert" 
            			ContextMenu="New"/>
        </Element>
        <Element Name="btn_edit" 
       			Class="Button" 
       			Text="Edit" 
       			CssClass="button_gray_m" 
       			Description="Edit record (Ctrl+E)">
            <EventHandler Name="btn_edit_onclick" 
            			Event="onclick" 
            			EventLogMsg="" 
            			Function="EditRecord()" 
            			RedirectPage="form={$edit_form_full_name}&amp;fld:Id={literal}{@:Elem[fld_Id].Value}{/literal}" 
            			ShortcutKey="Ctrl+E" 
            			ContextMenu="Edit" />
        </Element>
        <Element Name="btn_copy" 
        		Class="Button" 
        		Text="Copy" 
        		CssClass="button_gray_m" 
        		Description="Copy record (Ctrl+C)" >
            <EventHandler Name="btn_copy_onclick" 
            			Event="onclick" 
            			EventLogMsg="" 
            			Function="CopyRecord()" 
            			RedirectPage="form={$copy_form_full_name}&amp;fld:Id={literal}{@:Elem[fld_Id].Value}{/literal}" 
            			ShortcutKey="Ctrl+C" 
            			ContextMenu="Copy"/>
        </Element>
                
        <Element Name="btn_delete" 
        		Class="Button" 
        		Text="Delete" 
        		CssClass="button_gray_m" >
            <EventHandler Name="del_onclick" 
            			Event="onclick" 
            			EventLogMsg="" 
            			Function="DeleteRecord()" 
            			ShortcutKey="Ctrl+Delete" 
            			ContextMenu="Delete"/>
        </Element>
        <Element Name="btn_excel" 
        		Class="Button" 
        		Text="Export" 
        		CssClass="button_gray_m">
            <EventHandler Name="exc_onclick" 
            			Event="onclick" 
            			EventLogMsg="" 
            			Function="CallService(excelService,renderCSV)" 
            			FunctionType="Popup" 
            			ShortcutKey="Ctrl+X" 
            			ContextMenu="Export"/>
        </Element>
    </ActionPanel> 
    <NavPanel>
    {literal}
    	<Element Name="page_selector" 
    			Class="PageSelector" 
    			Text="{@:m_CurrentPage}" 
    			Label="Go to Page" 
    			CssClass="input_select" 
    			cssFocusClass="input_select_focus">
            <EventHandler Name="btn_page_selector_onchange" 
            			Event="onchange" 
            			Function="GotoSelectedPage(page_selector)"/>
        </Element>
        <Element Name="pagesize_selector" 
        		Class="PagesizeSelector" 
        		Text="{@:m_Range}" 
        		Label="Show Rows" 
        		CssClass="input_select" 
        		CssFocusClass="input_select_focus">
            <EventHandler Name="btn_pagesize_selector_onchange" 
            			Event="onchange" 
            			Function="SetPageSize(pagesize_selector)"/>
        </Element>    
        <Element Name="btn_first" 
        		Class="Button" 
        		Enabled="{(@:m_CurrentPage == 1)?'N':'Y'}" 
        		Text="" 
        		CssClass="button_gray_navi {(@:m_CurrentPage == 1)?'first_gray':'first'}">
            <EventHandler 
            		Name="first_onclick" 
            		Event="onclick" 
            		Function="GotoPage(1)"/>
        </Element>
        <Element Name="btn_prev" 
        		Class="Button" 
        		Enabled="{(@:m_CurrentPage == 1)?'N':'Y'}" 
        		Text="" 
        		CssClass="button_gray_navi {(@:m_CurrentPage == 1)?'prev_gray':'prev'}">
            <EventHandler Name="prev_onclick" 
            			Event="onclick" 
            			Function="GotoPage({@:m_CurrentPage - 1})" 
            			ShortcutKey="Ctrl+Shift+Left"/>
        </Element>
        <Element Name="txt_page" 
        		Class="LabelText" 
        		Text="{'@:m_CurrentPage of @:m_TotalPages '}">
        </Element>
        <Element Name="btn_next" 
        		Class="Button" 
        		Enabled="{(@:m_CurrentPage == @:m_TotalPages )?'N':'Y'}" 
        		Text="" 
        		CssClass="button_gray_navi {(@:m_CurrentPage == @:m_TotalPages)?'next_gray':'next'}">
            <EventHandler Name="next_onclick" 
            			Event="onclick" 
            			Function="GotoPage({@:m_CurrentPage + 1})" 
            			ShortcutKey="Ctrl+Shift+Right"/>
        </Element>
        <Element Name="btn_last" 
        		Class="Button" 
        		Enabled="{(@:m_CurrentPage == @:m_TotalPages )?'N':'Y'}" 
        		Text="" 
        		CssClass="button_gray_navi {(@:m_CurrentPage == @:m_TotalPages)?'last_gray':'last'}">
            <EventHandler Name="last_onclick" 
            			Event="onclick" 
            			Function="GotoPage({@:m_TotalPages})"/>
        </Element>
    {/literal}
    </NavPanel> 
    <SearchPanel>
    <Element Name="data_filter"  
    		BlankOption="All Data" 
    		cssclass="input_select_w" 
    		Class="common.element.ShareDataFilter" 
    		FieldName="create_by" 
    		Label="" 
    		SelectFrom="common.lov.DataSharingLOV(DataFilter)" >
            <EventHandler Name="datafilter_onchange" 
            		Event="onchange" 
            		Function="RunSearch()"/>
        </Element>
        
        <Element Name="qry_name"  
        		Class="AutoSuggest" 
        		FuzzySearch="Y" 
        		SelectFrom="{$form_do}[name],[name] like {literal}'%{$_POST['qry_name']}%'{/literal} GROUP BY [name]" 
        		FieldName="name" 
        		CssFocusClass="input_text_search_focus" 
        		CssClass="input_text_search"/>
        		
        <Element Name="btn_dosearch" 
        		Class="Button" 
        		Text="Go" 
        		CssClass="button_gray">
            <EventHandler Name="search_onclick" 
            			Event="onclick" 
            			Function="RunSearch()" 
            			ShortcutKey="Enter"/>
        </Element>     
    </SearchPanel>
</EasyForm>
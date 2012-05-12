<?xml version="1.0" encoding="UTF-8"?>
<EasyForm Name="{$form_name}" 
			Class="{$form_class}" 
			FormType="List" 
			jsClass="OpenbizForm" 
			Title="{$form_title}" 
			Description="{$form_description}" 
			BizDataObj="{$form_do}" 
			PageSize="10" 
			DefaultForm="Y" 
			TemplateEngine="Smarty" 
			TemplateFile="{$form_template}" 
			EventName="{$event_name}" 
			MessageFile="{$message_file}" 
			Access="{$acl.access}">
	<DataPanel>
{assign var=col_counter value=0}            
{foreach from=$fields item=fld}
{if $fld.Field == 'id'}
		<Element Name="row_selections" 
        			Class="RowCheckbox"  
        			Label="" 
        			FieldName="Id"/>
		<Element Name="fld_Id" 
        			Class="common.element.ColumnTitle" 
        			FieldName="Id" 
        			Label="ID" 
        			Sortable="Y" 
        			AllowURLParam="N" 
        			Link="javascript:;" />        
{elseif $fld.Field == 'sort_order' || $fld.Field == 'sortorder' }
		<Element Name="fld_{$fld.Field}" 
        			Class="ColumnSorting" 
        			FieldName="{$fld.Field}" 
        			Label="Sorting"  
        			Sortable="Y" 
        			AllowURLParam="N" 
        			Translatable="N" 
        			OnEventLog="N" >
			<EventHandler Name="fld_sortorder_up" 
        					Event="onclick" 
        					EventLogMsg="" 
        					Function="UpdateFieldValue({literal}{@:Elem[fld_Id].Value}{/literal},fld_{$fld.Field},{literal}{{/literal}@:Elem[fld_{$fld.Field}].Value-5{literal}}{/literal})" />
			<EventHandler Name="fld_sortorder_down" 
        					Event="onclick" 
        					EventLogMsg="" 
        					Function="UpdateFieldValue({literal}{@:Elem[fld_Id].Value}{/literal},fld_{$fld.Field},{literal}{{/literal}@:Elem[fld_{$fld.Field}].Value+5{literal}}{/literal})" />
		</Element>
{elseif $fld.Field == 'status'}
		<Element Name="fld_status" 
					Class="ColumnBool" 
					FieldName="status" 
					Label="Status"  
					Sortable="Y" 
					AllowURLParam="N" 
					Translatable="N" 
					OnEventLog="N" 
					Link="javascript:;">
			<EventHandler Name="fld_status_onclick" 
							Event="onclick" 
							Function="UpdateFieldValueXor({literal}{@:Elem[fld_Id].Value}{/literal},fld_status,{literal}{@:Elem[fld_status].Value}{/literal})"/>		
		</Element>
{elseif $fld.Type != 'timestamp'  && 
		$fld.Field != 'create_by' && 
		$fld.Field != 'create_time' && 
		$fld.Field != 'update_by' && 
		$fld.Field != 'update_time' && 
		$fld.Field != 'type_id' &&
		$fld.Field != 'owner_id' &&
		$fld.Field != 'group_id' &&
		$fld.Field != 'group_perm' &&
		$fld.Field != 'other_perm' 
		}
{if $col_counter==1}
		<Element Name="fld_{$fld.Field}" 
        			Class="ColumnText" 
        			FieldName="{$fld.Field}" 
        			Label="{$fld.FieldLabel}"         			 
        			Sortable="Y" 
        			MaxLength="15"
        			Link="{literal}{APP_INDEX}{/literal}/{$detail_view_url}/{literal}{@:Elem[fld_Id].Value}{/literal}"        			
        			{if $fld.Default != 'NULL' && $fld.Default != '' }DefaultValue="{$fld.Default}"{/if} />
{else}
		<Element Name="fld_{$fld.Field}" 
        			Class="ColumnText" 
        			FieldName="{$fld.Field}" 
        			Label="{$fld.FieldLabel}" 
        			MaxLength="15"        			 
        			Sortable="Y"
        			{if $fld.Default != 'NULL' && $fld.Default != '' }DefaultValue="{$fld.Default}"{/if} />
{/if}
        	
{/if}
{assign var=col_counter value=$col_counter+1}
{/foreach}
	</DataPanel>
    <ActionPanel>
    	<!-- Create New Record Button -->
        <Element Name="btn_new" 
        			Class="Button" 
        			Text="Add" 
        			CssClass="button_gray_add" 
        			Description="New record (Insert)" 
        			Access="{$acl.create}">
            <EventHandler Name="lnk_new_onclick" 
            				Event="onclick" 
            				EventLogMsg="" 
            				Function="SwitchForm({$comp}.{$new_form})"  
            				ShortcutKey="Insert" 
            				ContextMenu="New"/>
        </Element>
        
        <!-- Edit Selected Record Button -->
        <Element Name="btn_edit" 
        			Class="Button" 
        			Text="Edit" 
        			CssClass="button_gray_m" 
        			Description="Edit record (Ctrl+E)" 
        			Access="{$acl.update}">
            <EventHandler Name="btn_edit_onclick" 
            				Event="onclick" 
            				EventLogMsg="" 
            				Function="EditRecord()" 
            				RedirectPage="form={$comp}.{$edit_form}&amp;fld:Id={literal}{@:Elem[fld_Id].Value}{/literal}" 
            				ShortcutKey="Ctrl+E" 
            				ContextMenu="Edit" />
        </Element>
        
        <!-- Copy Selected Record Button -->
        <Element Name="btn_copy" 
        			Class="Button" 
        			Text="Copy" 
        			CssClass="button_gray_m" 
        			Description="Copy record (Ctrl+C)" 
        			Access="{$acl.create}">
            <EventHandler Name="btn_copy_onclick" 
            				Event="onclick" 
            				EventLogMsg="" 
            				Function="CopyRecord()" 
            				RedirectPage="form={$comp}.{$copy_form}&amp;fld:Id={literal}{@:Elem[fld_Id].Value}{/literal}" 
            				ShortcutKey="Ctrl+C" 
            				ContextMenu="Copy"/>
        </Element>
        
        <!-- Delete Selected Record Button -->
        <Element Name="btn_delete" 
        			Class="Button" 
        			Text="Delete" 
        			CssClass="button_gray_m" 
        			Description="Delete record"
        			Access="{$acl.delete}">
            <EventHandler Name="del_onclick" 
            				Event="onclick" 
            				EventLogMsg="" 
            				Function="DeleteRecord()" 
            				ShortcutKey="Ctrl+Delete" 
            				ContextMenu="Delete"/>
        </Element>
        
        <!-- Export Records Button -->
        <Element Name="btn_excel" 
        			Class="Button" 
        			Text="Export" 
        			Description="Export records"
        			CssClass="button_gray_m">
            <EventHandler Name="export_onclick" 
            				Event="onclick" 
            				EventLogMsg="" 
            				Function="CallService(excelService,renderCSV)" 
            				FunctionType="Popup" 
            				ShortcutKey="Ctrl+Shift+X" 
            				ContextMenu="Export"/>
        </Element>
    </ActionPanel> 
    <NavPanel>
    	{literal}
    	<!-- Page Selector -->
		<Element  Name="page_selector" 
					Class="PageSelector" 
					Text="{@:m_CurrentPage}" 
					Label="Go to Page" 
					CssClass="input_select" 
					CssFocusClass="input_select_focus">
            <EventHandler Name="btn_page_selector_onchange" 
            				Event="onchange" 
            				Function="GotoSelectedPage(page_selector)"/>
        </Element>
        
        <!-- Page Size Selector -->
        <Element  Name="pagesize_selector" 
        			Class="PagesizeSelector" 
        			Text="{@:m_Range}" 
        			Label="Show Rows" 
        			CssClass="input_select" 
        			CssFocusClass="input_select_focus">
            <EventHandler Name="btn_pagesize_selector_onchange" 
            				Event="onchange" 
            				Function="SetPageSize(pagesize_selector)"/>
        </Element> 
        
        <!-- Goto First Page Button -->   
        <Element  Name="btn_first" 
        			Class="Button" 
        			Enabled="{(@:m_CurrentPage == 1)?'N':'Y'}" 
        			CssClass="button_gray_navi {(@:m_CurrentPage == 1)?'first_gray':'first'}">
            <EventHandler Name="first_onclick" 
            				Event="onclick" 
            				Function="GotoPage(1)"/>
        </Element>
        
        <!-- Goto Previous Page Button -->   
        <Element Name="btn_prev" 
        			Class="Button" 
        			Enabled="{(@:m_CurrentPage == 1)?'N':'Y'}" 
        			CssClass="button_gray_navi {(@:m_CurrentPage == 1)?'prev_gray':'prev'}">
            <EventHandler Name="prev_onclick" 
            				Event="onclick" 
            				Function="GotoPage({@:m_CurrentPage - 1})" 
            				ShortcutKey="Ctrl+Shift+Left"/>
        </Element>
        
        <!-- Display Current Page / Total Pages -->
        <Element Name="txt_page" 
        			Class="LabelText" 
        			Text="{'@:m_CurrentPage of @:m_TotalPages '}">
        </Element>
        
        <!-- Goto Next Page Button -->  
        <Element Name="btn_next" 
        			Class="Button" 
        			Enabled="{(@:m_CurrentPage == @:m_TotalPages )?'N':'Y'}" 
        			CssClass="button_gray_navi {(@:m_CurrentPage == @:m_TotalPages)?'next_gray':'next'}">
            <EventHandler Name="next_onclick" 
            				Event="onclick" 
            				Function="GotoPage({@:m_CurrentPage + 1})" 
            				ShortcutKey="Ctrl+Shift+Right"/>
        </Element>
        
        <!-- Goto Last Page Button -->  
        <Element  Name="btn_last" 
        			Class="Button" 
        			Enabled="{(@:m_CurrentPage == @:m_TotalPages )?'N':'Y'}" 
        			CssClass="button_gray_navi {(@:m_CurrentPage == @:m_TotalPages)?'last_gray':'last'}">
            <EventHandler Name="last_onclick" 
            				Event="onclick" 
            				Function="GotoPage({@:m_TotalPages})"/>
        </Element>
        {/literal}
    </NavPanel> 
    <SearchPanel>
    	<Element Name="data_filter"  BlankOption="All Data" cssclass="input_select_m" Class="common.element.ShareDataFilter" FieldName="create_by" Label="" SelectFrom="common.lov.DataSharingLOV(DataFilter)" >
            <EventHandler Name="datafilter_onchange" Event="onchange" Function="RunSearch()"/>
        </Element>
    	<Element Name="type_selector"  BlankOption="All Types" cssclass="input_select_m" Class="collab.lib.TypeSelector" FieldName="type_id" Label="" SelectFrom="collab.bookmark.do.BookmarkTypeDO[name:Id:color]" >
            <EventHandler Name="type_selector_onchange" Event="onchange" Function="RunSearch()"/>
        </Element> 
    {if $searchs|@count > 0}	
	{assign var=fld value=$searchs[0] }
		<Element Name="qry_{$fld.COL_NAME}" Class="AutoSuggest" SelectFrom="{$comp}.{$do_name}[{$fld.COL_NAME}],[{$fld.COL_NAME}] like {literal}'%{@:Elem{/literal}[qry_{$fld.COL_NAME}].Value{literal}}{/literal}%' GROUP BY [{$fld.COL_NAME}]" FuzzySearch="Y" FieldName="{$fld.COL_NAME}" Label="" cssFocusClass="input_text_search_focus" CssClass="input_text_search" />
        <Element Name="btn_dosearch" Class="Button" text="Go" CssClass="button_gray">
            <EventHandler Name="search_onclick" Event="onclick" Function="RunSearch()" ShortcutKey="Enter"/>
        </Element>	
	{/if}
       
    </SearchPanel>
</EasyForm>